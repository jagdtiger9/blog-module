<?php

namespace Aljerom\Blog\Services\safeinput;

class safeinput extends Jevix
{
    public function __construct()
    {
        $this->Jevix = new Jevix();
        // 1. Устанавливаем разрешённые теги. (Все не разрешенные теги считаются запрещенными.)
        $this->Jevix->cfgAllowTags(
            array('a', 'img', 'i', 'b', 'u', 'em', 'strong', 'nobr', 'li', 'ol', 'ul', 'sup', 'abbr', 'pre', 'acronym',
                  'hr', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'br', 'code', 'blockquote', 'sub', 'sup', 'table', 'tr', 'td', 'th', 'p', 'span', 'announce',
                  'iframe', 'small', 'param', 'fieldset', 'legend', 'center')
        );

        // 2. Устанавливаем коротие теги. (не имеющие закрывающего тега)
        $this->Jevix->cfgSetTagShort(array('br', 'img', 'hr'));

        // 2. Устанавливаем пустые теги. (Не короткие теги которые не нужно удалять с пустым содержанием: <param name="code" value="die!"></param>)
        $this->Jevix->cfgSetTagIsEmpty(array('a', 'param'));

        // 3. Устанавливаем преформатированные теги. (в них все будет заменятся на HTML сущности)
        $this->Jevix->cfgSetTagPreformatted(array('pre'));

        // 4. Устанавливаем теги, которые необходимо вырезать из текста вместе с контентом.
        if ($_SESSION['login'] == 'cuca') {
            $this->Jevix->cfgSetTagCutWithContent(array('script', 'object', 'style'));
        } else {
            $this->Jevix->cfgSetTagCutWithContent(array('script', 'object', 'iframe', 'style'));
        }

        // 5. Устанавливаем разрешённые параметры тегов. Также можно устанавливать допустимые значения этих параметров.
        $this->Jevix->cfgAllowTagParams('h1', array('style'));
        $this->Jevix->cfgAllowTagParams('h2', array('style'));
        $this->Jevix->cfgAllowTagParams('h3', array('style'));
        $this->Jevix->cfgAllowTagParams('h4', array('style'));
        $this->Jevix->cfgAllowTagParams('h5', array('style'));
        $this->Jevix->cfgAllowTagParams('h6', array('style'));
        $this->Jevix->cfgAllowTagParams('a', array('title', 'href' => '#text', 'name'));
        $this->Jevix->cfgAllowTagParams(
            'img',
            array('src', 'alt' => '#text', 'title', 'align' => array('right', 'left', 'center'), 'width' => '#int', 'height' => '#int',
                  'hspace' => '#int', 'vspace' => '#int', 'border' => '#int', 'style', 'class')
        );
        $this->Jevix->cfgAllowTagParams('span', array('class', 'style'));
        $this->Jevix->cfgAllowTagParams('div', array('class', 'style'));
        $this->Jevix->cfgAllowTagParams('p', array('class', 'style'));
        $this->Jevix->cfgAllowTagParams('hr', array('size', 'noshade', 'class'));
        $this->Jevix->cfgAllowTagParams('fieldset', array('class', 'style'));
        $this->Jevix->cfgAllowTagParams('br', array('clear', 'style'));
        if ($_SESSION['login'] == 'cuca') {
            $this->Jevix->cfgAllowTagParams('iframe', array('src', 'style'));
        }

        // 6. Устанавливаем параметры тегов являющиеся обязяательными. Без них вырезает тег оставляя содержимое.
        $this->Jevix->cfgSetTagParamsRequired('img', 'src');
        //$this->Jevix->cfgSetTagParamsRequired('a', 'href');

        // 7. Устанавливаем теги которые может содержать тег контейнер
        //    cfgSetTagChilds($tag, $childs, $isContainerOnly, $isChildOnly)
        //       $isContainerOnly : тег является только контейнером для других тегов и не может содержать текст (по умолчанию false)
        //       $isChildOnly : вложенные теги не могут присутствовать нигде кроме указанного тега (по умолчанию false)
        //$this->Jevix->cfgSetTagChilds('ul', 'li', true, true);

        // 8. Устанавливаем атрибуты тегов, которые будут добавлятся автоматически
        //$this->Jevix->cfgSetTagParamsAutoAdd('a', array('rel' => 'nofollow'));
        //$this->Jevix->cfgSetTagParamsAutoAdd('img', array('border=' => '0'));

        // 9. Устанавливаем автозамену
        $this->Jevix->cfgSetAutoReplace(array('+/-', '(c)', '(r)'), array('±', '©', '®'));

        // 10. Включаем или выключаем режим XHTML. (по умолчанию включен)
        $this->Jevix->cfgSetXHTMLMode(true);

        // 11. Включаем или выключаем режим замены переноса строк на тег <br/>. (по умолчанию включен)
        #$this->Jevix->cfgSetAutoBrMode(true);
        $this->Jevix->cfgSetAutoBrMode(false);

        // 12. Включаем или выключаем режим автоматического определения ссылок. (по умолчанию включен)
        #$this->cfgSetAutoLinkMode(true);
        $this->Jevix->cfgSetAutoLinkMode(false);

        // 13. Отключаем типографирование в определенном теге
        $this->Jevix->cfgSetTagNoTypography('code');
    }

    public function Parce($text)
    {
        $text = $this->Jevix->parse($text, $errors);
        return $text;
    }
}
