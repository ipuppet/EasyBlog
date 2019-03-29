<?php

namespace EasyBlog\Ext;

class htmlSecuritySplit
{
    /**
     * 判断标签闭合情况
     *
     * @return array 未配对的标签
     */
    private function getIncompleteTags($html): array
    {
        $p = '/\<([^\s\>(hr)(br)]+)/';
        preg_match_all($p, $html, $tags);
        $tags = $tags[1];
        $len = count($tags);
        for ($i = 0; $i < $len; $i++) {
            if (substr($tags[$i], 0, 1) === '/') {
                $endTag = substr($tags[$i], 1);
                $index = $i - 1;
                while (1) {
                    if (isset($tags[$index])) {
                        $lastTag = $tags[$index];
                        break;
                    } else {
                        if ($index !== 0)
                            $index--;
                        else
                            break;
                    }
                }
                while (1) {
                    if ($lastTag === $endTag) {
                        unset($tags[$i]);
                        unset($tags[$index]);
                        $lastTag = '';
                    }
                    break;
                }
            }
        }
        return $tags;
    }

    /**
     * 修复被切断的html
     *
     * @return string 修复后的html
     */
    public function repairHtml($html): string
    {
        $incompleteTags = $this->getIncompleteTags($html);
        foreach ($incompleteTags as $incompleteTag) {
            if (substr($incompleteTag, 0, 1) === '/') {
                $newTags = substr($incompleteTag, 1);
                $html = "<{$newTags}>" . $html;
            } else {
                $html = $html . "</{$incompleteTag}>";
            }
        }
        return $html;
    }

    /**
     * 裁剪某个长度的html
     *
     * @return string 安全裁剪后的html
     */
    public function cutHtml($html, $len, $start = 0): string
    {
        $html = substr($html, $start, $len);
        $incompleteTags = $this->getIncompleteTags($html);
        foreach ($incompleteTags as $incompleteTag) {
            if (substr($incompleteTag, 0, 1) === '/') {
                $newTags = substr($incompleteTag, 1);
                $html = "<{$newTags}>" . $html;
            } else {
                $html = $html . "</{$incompleteTag}>";
            }
        }
        return $html;
    }
}
