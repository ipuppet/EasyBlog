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

/* tag.html.twig */
class __TwigTemplate_0bf30b9d94e12a101833566036d915e69a449c25bc4f10a47e29410302ec4b67 extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "tag.html.twig", 1);
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
        echo twig_escape_filter($this->env, ($context["tag"] ?? null), "html", null, true);
        echo " 标签";
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
        <div class=\"choose-tag animated flipInX\">
            \"";
        // line 9
        echo twig_escape_filter($this->env, ($context["tag"] ?? null), "html", null, true);
        echo "\" 标签下的内容
        </div>
        ";
        // line 11
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["articles"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["article"]) {
            // line 12
            echo "            <div class=\"article animated zoomIn\">
                <div class=\"title\">
                    <a href=\"/detail/";
            // line 14
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "aid", []), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "title", []), "html", null, true);
            echo "</a>
                </div>
                <div class=\"info\">
                    <span>";
            // line 17
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "creatDate", []), "html", null, true);
            echo "</span>
                </div>
                <div>
                    ";
            // line 20
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
        // line 26
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
        return "tag.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  107 => 26,  95 => 20,  89 => 17,  81 => 14,  77 => 12,  73 => 11,  68 => 9,  64 => 7,  61 => 6,  56 => 4,  53 => 3,  46 => 2,  27 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"base.html.twig\" %}
{% block title %}{{ tag }} 标签{% endblock %}
{% block head %}
    <link rel=\"stylesheet\" href=\"/public/static/css/list.css\"/>
{% endblock %}
{% block body %}
    <div class=\"list\">
        <div class=\"choose-tag animated flipInX\">
            \"{{ tag }}\" 标签下的内容
        </div>
        {% for article in articles %}
            <div class=\"article animated zoomIn\">
                <div class=\"title\">
                    <a href=\"/detail/{{ article.aid }}\">{{ article.title }}</a>
                </div>
                <div class=\"info\">
                    <span>{{ article.creatDate }}</span>
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
        //添加动画
        listDelay = 500;
        \$('.article').each(function () {
            \$(this).css('animation-delay', listDelay + 'ms');
            listDelay += 200;
        })
    </script>
{% endblock %}", "tag.html.twig", "C:\\Users\\ziming\\Project\\www\\EasyBlog\\app\\templates\\list\\tag.html.twig");
    }
}
