<?php

namespace EasyBlog\Controller;

use EasyBlog\Core\Controller;

class apiController extends Controller
{
    public function translationAction($kw = null, $to = null, $from = null, $multiple = false)
    {
        if (!isset($_POST['kw']) && $kw === null) {
            die('{"error":"no word"}');
        } else {
            if ($kw === null)
                $kw = $_POST['kw'];

            if ($to === null)
                $to = isset($_POST['to']) ? $_POST['to'] : 'zh';

            if ($from === null)
                $from = isset($_POST['from']) ? $_POST['from'] : 'auto';

            $url = "https://fanyi.baidu.com/transapi?from={$from}&to={$to}&query={$kw}";
            $ch = curl_init();
            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 60,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            );
            curl_setopt_array($ch, $options);
            $output = curl_exec($ch);
            if ($output === FALSE) {
                echo "CURL Error:" . curl_error($ch);
                curl_close($ch);
                return false;
            } else {
                $result = json_decode($output, true);
                $translation = $result['data'][0]['dst'];
                $original = $result['data'][0]['src'];
                if (!$multiple)
                    echo '{"from":"', $from, '","to","', $to, '","translation":"', $translation, '","original":"', $original, '"}';
                curl_close($ch);
                return $translation;
            }
        }
    }

    public function multipleTranslationAction()
    {
        if (!isset($_POST['kw'])) {
            die('{"error":"no word"}');
        } else {
            $kw = $_POST['kw'];
            $original = $kw;
            $lanList = [
                'fra',
                'jp',
                'yue',
                'jp',
                'zh',
            ];
            foreach ($lanList as $lan) {
                $kw = $this->translationAction($kw, $lan, 'auto', true);
                //sleep(0.5);
            }
            echo '{"original":"', $original, '","result":"', $kw, '"}';
        }
    }
}