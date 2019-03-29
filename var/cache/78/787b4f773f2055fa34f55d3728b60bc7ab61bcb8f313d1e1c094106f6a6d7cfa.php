<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* index.html.twig */
class __TwigTemplate_219bed7989e6c7624c01813d6e70ee251330ba3570ea2d8dd214f9d58ea53e9b extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "index.html.twig", 1);
        $this->blocks = [
            'title' => [$this, 'block_title'],
            'head' => [$this, 'block_head'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["about"] ?? null), "name", []), "html", null, true);
        echo "'s blog";
    }

    // line 3
    public function block_head($context, array $blocks = [])
    {
        // line 4
        echo "    <link rel=\"stylesheet\" href=\"/public/static/css/index.css\"/>
";
    }

    // line 6
    public function block_body($context, array $blocks = [])
    {
        // line 7
        echo "    <div class=\"articleList\">
        ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["articles"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["article"]) {
            // line 9
            echo "            <div class=\"article animated zoomIn\">
                <div class=\"title\">
                    <a href=\"/detail/";
            // line 11
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "aid", []), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "title", []), "html", null, true);
            echo "</a>
                </div>
                <div class=\"info\">
                    <span>";
            // line 14
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "creatDate", []), "html", null, true);
            echo "</span>
                    ";
            // line 15
            if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "tags", [])) > 0)) {
                // line 16
                echo "                        &nbsp;|&nbsp;标签：
                        ";
                // line 17
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["article"], "tags", []));
                foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
                    // line 18
                    echo "                            <a class=\"tag\" href=\"/tag/";
                    echo twig_escape_filter($this->env, $context["tag"], "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, $context["tag"], "html", null, true);
                    echo "</a>&nbsp;
                        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 20
                echo "                    ";
            }
            // line 21
            echo "                </div>
                <div>
                    ";
            // line 23
            echo twig_get_attribute($this->env, $this->source, $context["article"], "abstract", []);
            echo "
                    ...
                </div>
                <hr>
            </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['article'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 29
        echo "    </div>
    <script>
        \$(document).ready(function () {
            //给图片加上盒子
            \$('.articleList').find('img').each(function () {
                \$(this).wrapAll('<div class=\"img-container\"></div>');
                let width = \$(this).width();
                \$(this).height(width * 9 / 16)
            });
            //图片加载检测
            var imgLoad = imagesLoaded('.articleList');
            imgLoad.on('always', function () {
                for (var i = 0, len = imgLoad.images.length; i < len; i++) {
                    var image = imgLoad.images[i];
                    if (image.isLoaded) {
                        \$(image.img).animate({
                            'opacity': 1,
                        }, 500);
                        console.log('image ' + image.img.src + ' is successfully loaded');
                    } else {
                        console.log('image is broken for ' + image.img.src);
                    }
                }
            });
        });
        //添加动画
        listDelay = 500;
        \$('.article').each(function () {
            \$(this).css('animation-delay', listDelay + 'ms');
            listDelay += 200;
        })
    </script>
";
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  126 => 29,  114 => 23,  110 => 21,  107 => 20,  96 => 18,  92 => 17,  89 => 16,  87 => 15,  83 => 14,  75 => 11,  71 => 9,  67 => 8,  64 => 7,  61 => 6,  56 => 4,  53 => 3,  46 => 2,  27 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"base.html.twig\" %}
{% block title %}{{ about.name }}'s blog{% endblock %}
{% block head %}
    <link rel=\"stylesheet\" href=\"/public/static/css/index.css\"/>
{% endblock %}
{% block body %}
    <div class=\"articleList\">
        {% for article in articles %}
            <div class=\"article animated zoomIn\">
                <div class=\"title\">
                    <a href=\"/detail/{{ article.aid }}\">{{ article.title }}</a>
                </div>
                <div class=\"info\">
                    <span>{{ article.creatDate }}</span>
                    {% if article.tags|length>0 %}
                        &nbsp;|&nbsp;标签：
                        {% for tag in article.tags %}
                            <a class=\"tag\" href=\"/tag/{{ tag }}\">{{ tag }}</a>&nbsp;
                        {% endfor %}
                    {% endif %}
                </div>
                <div>
                    {{ article.abstract|raw }}
                    ...
                </div>
                <hr>
            </div>
        {% endfor %}
    </div>
    <script>
        \$(document).ready(function () {
            //给图片加上盒子
            \$('.articleList').find('img').each(function () {
                \$(this).wrapAll('<div class=\"img-container\"></div>');
                let width = \$(this).width();
                \$(this).height(width * 9 / 16)
            });
            //图片加载检测
            var imgLoad = imagesLoaded('.articleList');
            imgLoad.on('always', function () {
                for (var i = 0, len = imgLoad.images.length; i < len; i++) {
                    var image = imgLoad.images[i];
                    if (image.isLoaded) {
                        \$(image.img).animate({
                            'opacity': 1,
                        }, 500);
                        console.log('image ' + image.img.src + ' is successfully loaded');
                    } else {
                        console.log('image is broken for ' + image.img.src);
                    }
                }
            });
        });
        //添加动画
        listDelay = 500;
        \$('.article').each(function () {
            \$(this).css('animation-delay', listDelay + 'ms');
            listDelay += 200;
        })
    </script>
{% endblock %}", "index.html.twig", "C:\\Users\\ziming\\Project\\www\\EasyBlog\\app\\templates\\index.html.twig");
    }
}
