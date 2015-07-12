<?php
    namespace kyra\common;

    use yii\base\Exception;
    use yii\helpers\Markdown;

    class Json2HtmlRenderer
    {
        public static function Render($json)
        {
            $json = str_replace('\\\\', '', $json);
            $json = json_decode($json, true);
            if($json === false || $json === null) return false;

            $html = '';
            foreach($json['data'] as $part)
            {
                $render = 'Render'.$part['type'];
                $ret = self::$render($part['data']);
                if($part['type'] != 'columns')
                {
                    $ret = '<div class="columns-12">'.$ret.'</div>';
                }
                $html .= $ret;
            }
            return $html;
        }

        public static function RenderColumns($data)
        {
            $html = '<div class="'.$data['preset'].'">';

            foreach($data['columns'] as $column)
            {
                $html .= '<div class="column-'.$column['width'].'">';

                foreach($column['blocks'] as $block)
                {
                    $render = 'Render'.$block['type'];
                    $html .= self::$render($block['data']);

                }

                $html .= '</div>';
            }

            $html .= '</div>';

            $html = str_replace('\-', '-', $html);
            return $html;
        }

        public static function RenderMyText($data)
        {
            $md = Markdown::process($data['text'], 'gfm');
            return $md;
            $text = $data['text'];
            $text = strip_tags($text, '<b><i><br>');
            $text = preg_replace('|<br/?>$|mu', '', $text);$
            $text = trim($text);
            return '<p>'.$text.'</p>';
        }

        public static function RenderHeading($data)
        {
            $text = $data['text'];
            return '<h2>'.trim($text).'</h2>';
        }

        public static function RenderMyList($data)
        {
            $html = Markdown::process($data['text']);
            $html = str_replace('<ul>', '<ul class="list-'.$data['listtype'].'">', $html);
            return $html;
        }

        public static function RenderImageBox($data)
        {
            $key = $data['ImgSize'];
            if(isset($data['data']['Images'][$key])) $pathP = $data['data']['Images'][$key];
            else $pathP = $data['data']['Images']['preview'];
            $pathO = $data['data']['Images']['o'];

            $html = <<<DIV
<figure class="mediaholder">
    <a href="{$pathO}" class="popup"><img src="$pathP" class="image-box" />
    <figcaption>
    <h5>{$data['Name']}</h5>
    <span>{$data['Description']}</span>
    </figcaption>
    </a>
</figure>
DIV;
            return $html;
        }

        public static function RenderFeatureBox($data)
        {
            $html = <<<DIV
<div class="featured-box">
    <div class="circle"><i class="icon-{$data['Icon']}"></i><span></span></div>
    <div class="featured-desc">
        <h3>{$data['Name']}</h3>
        <p>{$data['Description']}</p>
    </div>
</div>
DIV;
            return $html;
        }

        public static function RenderImage($data)
        {
            $path = $data['data']['Images']['o'];
            $dataAttribs[] = 'data-iid="'.$data['data']['IID'].'"';
            foreach($data['data']['Images'] as $key=>$imgInfo)
            {
                $dataAttribs[] = 'data-'.$key.'="'.$imgInfo.'"';
            }

            $dataAttribs = implode(' ', $dataAttribs);
            $html = '<img src="'.$path.'" '.$dataAttribs.' />';
            return $html;
        }

        public static function RenderVideo($data)
        {
            $class = '';
            switch($data['source'])
            {
                case 'youtube' :
                    $path = '//www.youtube.com/embed/'.$data['remote_id'].'?showinfo=0&hd=1';
                    break;
                case 'vimeo' :
                    $path = '//player.vimeo.com/video/'.$data['remote_id'];
                    $class = 'vimeo';
            }
            $html = <<<DIV
<div class="js-video $class widescreen">
  <iframe width="560" height="315" src="$path" frameborder="0" allowfullscreen></iframe>
</div>
DIV;
            return $html;
        }

    }