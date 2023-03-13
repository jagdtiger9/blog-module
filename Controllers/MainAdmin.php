<?php

namespace Aljerom\Blog\Controllers;

use Aljerom\Blog\Models\Record;
use Aljerom\Blog\Services\safeinput\safeinput;
use App\Application\Exception\Runtime\E401NotAuthorized;
use Exception;
use MagicPro\Application\Controller;
use MagicPro\Contracts\User\SessionUserInterface;
use MagicPro\Database\Exception\DbException;
use MagicPro\Http\Api\ErrorResponse;
use MagicPro\Http\Api\SuccessResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MainAdmin extends Controller
{
    public function actionIndex(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('index');
    }

    public function actionAdd(
        ServerRequestInterface $request,
        $uid,
        $title,
        $content,
        $visibility,
        $printPlace,
        $category,
        SessionUserInterface $user,
    ): ResponseInterface {
        try {
            if (!$user->uid()) {
                throw new E401NotAuthorized('Доступ запрещен');
            }

            if ($uid) {
                if (null === $record = Record::find($uid)) {
                    throw new \InvalidArgumentException('Запись с указанным идентификатором не существует');
                }

                if ($record->userId != \app('session')->get('userid') && !$user->isAdmin()) {
                    throw new \InvalidArgumentException('Что-то пошло не так');
                }
            } else {
                $record = new Record();
            }

            // ПОбработка проблемы с амперсандами '&' в ссылках. WW меняет & на &amp; и jevix делает то же самое. Получаем &amp;amp;
            // Убираем изменения WW редактора
            $count = preg_match_all("|\shref=\"([^\"]+)\"|ms", $content, $matchRes);
            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    $content = str_replace($matchRes[1][$i], str_replace('&amp;', '&', $matchRes[1][$i]), $content);
                }
            }

            $record->setVisibility($visibility)
                ->setPrintPlace($printPlace);

            $record->category = (int)$category;
            $record->title = strip_tags($title);
            $record->ip = \app('request')->Server('REMOTE_ADDR');
            $record->setUser($user->uid(), $user->login());

            preg_match("|<iframe\s[^>]+></iframe>|ms", $content, $iframeRes);
            $content = str_replace($iframeRes[0], '[googleframe]', $content);
            $SafeInput = new safeinput();
            $content = $SafeInput->Parce($content);
            $content = str_replace('[googleframe]', $iframeRes[0], $content);
            $record->content = $content;
            $record->createTime = $record->uid ? $record->createTime : time();

            if (!$record->save()) {
                throw new DbException('Ошибка сохранения записи');
            }

            $back = $request->Post('an') ? _url('', $request->Post('an'), ['uid' => $record->uid]) : true;
            $apiResponse = new SuccessResponse('Запись успешно сохранена');
        } catch (Exception $e) {
            $apiResponse = ErrorResponse::fromException($e);
            $back = true;
        }

        return $this->setApiResponse($request, $apiResponse->withRedirect($back));
    }

    public function actionDelRecord(
        ServerRequestInterface $request,
        $uid,
        SessionUserInterface $user,
    ): ResponseInterface {
        try {
            if (!$user->uid()) {
                throw new E401NotAuthorized('Доступ запрещен');
            }

            if (!$uid) {
                throw new \InvalidArgumentException('Не задан идентификатор удаляемой записи');
            }
            if (null === $record = Record::find($uid)) {
                throw new \InvalidArgumentException('Запись с указанным идентификатором не существует');
            }

            if ($record->userId != \app('session')->get('userid') && !$user->isAdmin()) {
                throw new \InvalidArgumentException('Что-то пошло не так');
            }

            if (!$record->delete()) {
                throw new DbException('Ошибка сохранения записи');
            }

            $apiResponse = new SuccessResponse('Запись успешно удалена');
        } catch (Exception $e) {
            $apiResponse = ErrorResponse::fromException($e);
        }

        return $this->setApiResponse($request, $apiResponse->withRedirect());
    }
}
