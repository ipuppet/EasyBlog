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

/* search.html.twig */
class __TwigTemplate_4b784f73cfa5cb04310a293a3e3bc721209edb0bc2759e0d05a43bcfc97b6519 extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "search.html.twig", 1);
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
        echo "搜索结果";
    }

    // line 3
    public function block_head($context, array $blocks = [])
    {
        // line 4
        echo "    <link rel=\"stylesheet\" href=\"/public/static/css/list.css\"/>
";
    }

    // line 6
    public function block_body($context, array $blocks = [])
    {
        // line 7
        echo "    <div class=\"list\">
        <div class=\"kw animated flipInX\">
            \"";
        // line 9
        echo twig_escape_filter($this->env, ($context["kw"] ?? null), "html", null, true);
        echo "\"&nbsp;的搜索结果
        </div>
        ";
        // line 11
        if ((twig_length_filter($this->env, ($context["kw"] ?? null)) > 0)) {
            // line 12
            echo "            ";
            if ((twig_length_filter($this->env, ($context["articles"] ?? null)) > 0)) {
                // line 13
                echo "                ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["articles"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["article"]) {
                    // line 14
                    echo "                    <div class=\"article animated zoomIn\">
                        <div class=\"title\">
                            <a href=\"/detail/";
                    // line 16
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "aid", []), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "title", []), "html", null, true);
                    echo "</a>
                        </div>
                        <div class=\"info\">
                            <span>";
                    // line 19
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "creatDate", []), "html", null, true);
                    echo "</span>
                            ";
                    // line 20
                    if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "tags", [])) > 0)) {
                        // line 21
                        echo "                                &nbsp;|&nbsp;标签：
                                ";
                        // line 22
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["article"], "tags", []));
                        foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
                            // line 23
                            echo "                                    <a class=\"tag\" href=\"/tag/";
                            echo twig_escape_filter($this->env, $context["tag"], "html", null, true);
                            echo "\">";
                            echo twig_escape_filter($this->env, $context["tag"], "html", null, true);
                            echo "</a>&nbsp;
                                ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 25
                        echo "                            ";
                    }
                    // line 26
                    echo "                        </div>
                        <div>
                            ";
                    // line 28
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
                // line 34
                echo "            ";
            } else {
                // line 35
                echo "                <div class=\"noneMsg animated zoomIn\">没有找到哎。。。</div>
            ";
            }
            // line 37
            echo "        ";
        } else {
            // line 38
            echo "            <div class=\"noneMsg animated zoomIn\">请输入关键字！</div>
        ";
        }
        // line 40
        echo "    </div>
    <script>
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
        return "search.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  151 => 40,  147 => 38,  144 => 37,  140 => 35,  137 => 34,  125 => 28,  121 => 26,  118 => 25,  107 => 23,  103 => 22,  100 => 21,  98 => 20,  94 => 19,  86 => 16,  82 => 14,  77 => 13,  74 => 12,  72 => 11,  67 => 9,  63 => 7,  60 => 6,  55 => 4,  52 => 3,  46 => 2,  27 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}
{% block title %}搜索结果{% endblock %}
{% block head %}
    <link rel=\"stylesheet\" href=\"/public/static/css/list.css\"/>
{% endblock %}
{% block body %}
    <div class=\"list\">
        <div class=\"kw animated flipInX\">
            \"{{ kw }}\"&nbsp;的搜索结果
        </div>
        {% if kw|length>0 %}
            {% if articles|length>0 %}
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
            {% else %}
                <div class=\"noneMsg animated zoomIn\">没有找到哎。。。</div>
            {% endif %}
        {% else %}
            <div class=\"noneMsg animated zoomIn\">请输入关键字！</div>
        {% endif %}
    </div>
    <script>
        //添加动画
        listDelay = 500;
        \$('.article').each(function () {
            \$(this).css('animation-delay', listDelay + 'ms');
            listDelay += 200;
        })
    </script>
{% endblock %}", "search.html.twig", "C:\\Users\\ziming\\Project\\www\\EasyBlog\\app\\templates\\list\\search.html.twig");
    }
}
