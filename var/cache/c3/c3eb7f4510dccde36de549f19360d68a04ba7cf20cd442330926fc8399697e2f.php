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

/* base.html.twig */
class __TwigTemplate_9438db4d50c7744ac1d4e9493fa942c0368b89bbc4d8e00d98be23ef8f569523 extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'head' => [$this, 'block_head'],
            'body' => [$this, 'block_body'],
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"zh\">
<head>
    <meta charset=\"utf-8\">
    <meta content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\" name=\"viewport\">
    <script src=\"/public/static/library/jquery-3.3.1.min.js\"></script>
    <script src=\"/public/static/library/imagesloaded.pkgd.min.js\"></script>
    <script src=\"/public/static/library/bootstrap/js/bootstrap.min.js\"></script>
    <script src=\"/public/static/library/swiper-4.5.0/swiper.min.js\"></script>
    <link rel=\"stylesheet\" href=\"/public/static/library/bootstrap/css/bootstrap.min.css\"/>
    <link rel=\"stylesheet\" href=\"/public/static/library/animate.css\"/>
    <link rel=\"stylesheet\" href=\"/public/static/library/swiper-4.5.0/swiper.min.css\">
    <link rel=\"stylesheet\" href=\"/public/static/css/base.css\"/>
    <title>";
        // line 14
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    ";
        // line 15
        $this->displayBlock('head', $context, $blocks);
        // line 16
        echo "</head>
<body>
<div class=\"col-sm-12 nav\">
    <div class=\"nav-header animated fadeIn\">
        <div class=\"logo\">
            <span>Welcome To ";
        // line 21
        echo twig_escape_filter($this->env, twig_title_string_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["about"] ?? null), "name", [])), "html", null, true);
        echo "'s Blog</span>
        </div>
        <div class=\"sentence-container\">
            一个人至少拥有一个梦想，有一个理由去坚强。心若没有栖息的地方，到哪里都是在流浪。
        </div>
    </div>
</div>

<div class=\"container-fluid\" style=\"margin-bottom: 40px;padding: 0;\">
    ";
        // line 31
        echo "    <div class=\"col-sm-7\" style=\"padding: 0\">
        <div class=\"bodyBox col-sm-11 col-sm-offset-1\">
            ";
        // line 33
        $this->displayBlock('body', $context, $blocks);
        // line 34
        echo "        </div>
    </div>
    ";
        // line 37
        echo "    <div class=\"col-sm-5\" style=\"padding: 0\">
        <div class=\"col-sm-10 col-sm-offset-1\" style=\"padding: 0\">
            ";
        // line 40
        echo "            <div class=\"hidden-xs\" style=\"margin-top: -50px;\"></div>
            <div class=\"info-container\">
                <div class=\"table-container\">
                    <a href=\"/\" class=\"animated fadeIn\">
                        <div><span class=\"glyphicon glyphicon-home\"></span>&nbsp;首页</div>
                    </a>
                    <a href=\"/archives\" class=\"animated fadeIn\">
                        <div><span class=\"glyphicon glyphicon-time\"></span>&nbsp;归档</div>
                    </a>
                    <a href=\"/about\" class=\"animated fadeIn\">
                        <div><span class=\"glyphicon glyphicon-user\"></span>&nbsp;关于我</div>
                    </a>
                    <script>
                        var delay = 500;
                        \$('.table-container').find('a').each(function () {
                            \$(this).css('animation-delay', delay + 'ms');
                            delay += 150;
                        })
                    </script>
                </div>
                <div class=\"search-container animated fadeInDown\">
                    <input type=\"text\" placeholder=\"Search...\" id=\"kw\"
                           onkeypress=\"return onKeyPress(event)\">
                    <button onclick=\"search()\">
                        <span class=\"glyphicon glyphicon-search\"></span>
                    </button>
                    <script>
                        function onKeyPress(e) {
                            var keyCode = null;
                            if (e.which)
                                keyCode = e.which;
                            else if (e.keyCode)
                                keyCode = e.keyCode;
                            if (keyCode === 13) {
                                search();
                                return false;
                            }
                            return true;
                        }

                        function search() {
                            window.location.href = \"/search/\" + \$(\"#kw\").val()
                        }
                    </script>
                </div>
            </div>
            ";
        // line 87
        echo "            <div class=\"slideShow animated fadeInRight\">
                <div class=\"swiper-container\">
                    <div class=\"swiper-wrapper\">
                        ";
        // line 90
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["banners"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["banner"]) {
            // line 91
            echo "                            ";
            $context["bgstyle"] = ((":" . twig_get_attribute($this->env, $this->source, $context["banner"], "background", [])) . ";");
            // line 92
            echo "                            ";
            if (( !(twig_slice($this->env, twig_get_attribute($this->env, $this->source, $context["banner"], "background", []), 0, 1) === "r") &&  !(twig_slice($this->env, twig_get_attribute($this->env, $this->source, $context["banner"], "background", []), 0, 1) === "#"))) {
                // line 93
                echo "                                ";
                $context["bgstyle"] = (("-image:url(\"" . twig_get_attribute($this->env, $this->source, $context["banner"], "background", [])) . "\");");
                // line 94
                echo "                            ";
            }
            // line 95
            echo "                            <div class=\"swiper-slide\" style=\"background";
            echo twig_escape_filter($this->env, ($context["bgstyle"] ?? null), "html", null, true);
            echo "\">
                                <a href=\"";
            // line 96
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["banner"], "url", []), "html", null, true);
            echo "\">
                                    <div class=\"banner-block\">
                                        <div class=\"banner-title\" data-swiper-parallax=\"-400\">
                                            ";
            // line 99
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["banner"], "title", []), "html", null, true);
            echo "
                                        </div>
                                        <div class=\"banner-content\" data-swiper-parallax=\"-300\">
                                            ";
            // line 102
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["banner"], "abstract", []), "html", null, true);
            echo "
                                        </div>
                                    </div>
                                </a>
                            </div>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['banner'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 108
        echo "                    </div>
                    <!-- 分页器 -->
                    <div class=\"swiper-pagination\"></div>
                </div>
                <script>
                    var mySwiper = new Swiper('.swiper-container', {
                        //loop: true,
                        autoplay: {
                            delay: 5000
                        },
                        spaceBetween: 20,
                        touchRatio: 2,
                        parallax: true,

                        // 分页器
                        pagination: {
                            el: '.swiper-pagination',
                            dynamicBullets: true,//自动隐藏多的小圆点
                        },
                    })
                </script>
            </div>
            <div class=\"tagClouds animated fadeInRight\">
                已有标签<br>
                ";
        // line 132
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["tags"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
            // line 133
            echo "                    <a href=\"/tag/";
            echo twig_escape_filter($this->env, $context["tag"], "html", null, true);
            echo "\" class=\"tagCloud\">";
            echo twig_escape_filter($this->env, $context["tag"], "html", null, true);
            echo "</a>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 135
        echo "            </div>
            ";
        // line 137
        echo "        </div>
    </div>
    ";
        // line 140
        echo "</div>

<div class=\"back-top animated\" onclick=\"backTop()\">
    <span class=\"glyphicon glyphicon-menu-up\"></span>
    <script>
        function backTop(minHeight = 20) {
            \$('.back-top').click(function () {
                \$('html, body').animate({scrollTop: 0}, 200)
            });
            \$(window).scroll(function () {
                var s = \$(window).scrollTop();
                if (s > minHeight) {
                    \$('.back-top').fadeIn().addClass('fadeInRight faster').removeClass('zoomOutRight')
                } else {
                    \$('.back-top').addClass('zoomOutRight').removeClass('fadeInRight faster')
                }
            })
        }

        backTop()
    </script>
</div>
<div class=\"footer-base animated fadeIn delay-1s\">
    ";
        // line 163
        $this->displayBlock('footer', $context, $blocks);
        // line 172
        echo "</div>
</body>
</html>";
    }

    // line 14
    public function block_title($context, array $blocks = [])
    {
    }

    // line 15
    public function block_head($context, array $blocks = [])
    {
    }

    // line 33
    public function block_body($context, array $blocks = [])
    {
    }

    // line 163
    public function block_footer($context, array $blocks = [])
    {
        // line 164
        echo "        &copy; 2017-<span id=\"footer-base-time\"></span>&nbsp;
        <span class=\"glyphicon glyphicon-heart\"></span>&nbsp;";
        // line 165
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["about"] ?? null), "name", []), "html", null, true);
        echo "
        <script>
            let date = new Date;
            let year = date.getFullYear();
            \$('#footer-base-time').text(year);
        </script>
    ";
    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  293 => 165,  290 => 164,  287 => 163,  282 => 33,  277 => 15,  272 => 14,  266 => 172,  264 => 163,  239 => 140,  235 => 137,  232 => 135,  221 => 133,  217 => 132,  191 => 108,  179 => 102,  173 => 99,  167 => 96,  162 => 95,  159 => 94,  156 => 93,  153 => 92,  150 => 91,  146 => 90,  141 => 87,  93 => 40,  89 => 37,  85 => 34,  83 => 33,  79 => 31,  67 => 21,  60 => 16,  58 => 15,  54 => 14,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html lang=\"zh\">
<head>
    <meta charset=\"utf-8\">
    <meta content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\" name=\"viewport\">
    <script src=\"/public/static/library/jquery-3.3.1.min.js\"></script>
    <script src=\"/public/static/library/imagesloaded.pkgd.min.js\"></script>
    <script src=\"/public/static/library/bootstrap/js/bootstrap.min.js\"></script>
    <script src=\"/public/static/library/swiper-4.5.0/swiper.min.js\"></script>
    <link rel=\"stylesheet\" href=\"/public/static/library/bootstrap/css/bootstrap.min.css\"/>
    <link rel=\"stylesheet\" href=\"/public/static/library/animate.css\"/>
    <link rel=\"stylesheet\" href=\"/public/static/library/swiper-4.5.0/swiper.min.css\">
    <link rel=\"stylesheet\" href=\"/public/static/css/base.css\"/>
    <title>{% block title %}{% endblock %}</title>
    {% block head %}{% endblock %}
</head>
<body>
<div class=\"col-sm-12 nav\">
    <div class=\"nav-header animated fadeIn\">
        <div class=\"logo\">
            <span>Welcome To {{ about.name|title }}'s Blog</span>
        </div>
        <div class=\"sentence-container\">
            一个人至少拥有一个梦想，有一个理由去坚强。心若没有栖息的地方，到哪里都是在流浪。
        </div>
    </div>
</div>

<div class=\"container-fluid\" style=\"margin-bottom: 40px;padding: 0;\">
    {#博客正文#}
    <div class=\"col-sm-7\" style=\"padding: 0\">
        <div class=\"bodyBox col-sm-11 col-sm-offset-1\">
            {% block body %}{% endblock %}
        </div>
    </div>
    {#全局内容#}
    <div class=\"col-sm-5\" style=\"padding: 0\">
        <div class=\"col-sm-10 col-sm-offset-1\" style=\"padding: 0\">
            {#占位用div#}
            <div class=\"hidden-xs\" style=\"margin-top: -50px;\"></div>
            <div class=\"info-container\">
                <div class=\"table-container\">
                    <a href=\"/\" class=\"animated fadeIn\">
                        <div><span class=\"glyphicon glyphicon-home\"></span>&nbsp;首页</div>
                    </a>
                    <a href=\"/archives\" class=\"animated fadeIn\">
                        <div><span class=\"glyphicon glyphicon-time\"></span>&nbsp;归档</div>
                    </a>
                    <a href=\"/about\" class=\"animated fadeIn\">
                        <div><span class=\"glyphicon glyphicon-user\"></span>&nbsp;关于我</div>
                    </a>
                    <script>
                        var delay = 500;
                        \$('.table-container').find('a').each(function () {
                            \$(this).css('animation-delay', delay + 'ms');
                            delay += 150;
                        })
                    </script>
                </div>
                <div class=\"search-container animated fadeInDown\">
                    <input type=\"text\" placeholder=\"Search...\" id=\"kw\"
                           onkeypress=\"return onKeyPress(event)\">
                    <button onclick=\"search()\">
                        <span class=\"glyphicon glyphicon-search\"></span>
                    </button>
                    <script>
                        function onKeyPress(e) {
                            var keyCode = null;
                            if (e.which)
                                keyCode = e.which;
                            else if (e.keyCode)
                                keyCode = e.keyCode;
                            if (keyCode === 13) {
                                search();
                                return false;
                            }
                            return true;
                        }

                        function search() {
                            window.location.href = \"/search/\" + \$(\"#kw\").val()
                        }
                    </script>
                </div>
            </div>
            {#轮播图#}
            <div class=\"slideShow animated fadeInRight\">
                <div class=\"swiper-container\">
                    <div class=\"swiper-wrapper\">
                        {% for banner in banners %}
                            {% set bgstyle = ':' ~ banner.background ~ ';' %}
                            {% if banner.background|slice(0,1) is not same as('r') and banner.background|slice(0,1) is not same as('#') %}
                                {% set bgstyle = '-image:url(\"' ~ banner.background ~ '\");' %}
                            {% endif %}
                            <div class=\"swiper-slide\" style=\"background{{ bgstyle }}\">
                                <a href=\"{{ banner.url }}\">
                                    <div class=\"banner-block\">
                                        <div class=\"banner-title\" data-swiper-parallax=\"-400\">
                                            {{ banner.title }}
                                        </div>
                                        <div class=\"banner-content\" data-swiper-parallax=\"-300\">
                                            {{ banner.abstract }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        {% endfor %}
                    </div>
                    <!-- 分页器 -->
                    <div class=\"swiper-pagination\"></div>
                </div>
                <script>
                    var mySwiper = new Swiper('.swiper-container', {
                        //loop: true,
                        autoplay: {
                            delay: 5000
                        },
                        spaceBetween: 20,
                        touchRatio: 2,
                        parallax: true,

                        // 分页器
                        pagination: {
                            el: '.swiper-pagination',
                            dynamicBullets: true,//自动隐藏多的小圆点
                        },
                    })
                </script>
            </div>
            <div class=\"tagClouds animated fadeInRight\">
                已有标签<br>
                {% for tag in tags %}
                    <a href=\"/tag/{{ tag }}\" class=\"tagCloud\">{{ tag }}</a>
                {% endfor %}
            </div>
            {#end#}
        </div>
    </div>
    {#全局内容#}
</div>

<div class=\"back-top animated\" onclick=\"backTop()\">
    <span class=\"glyphicon glyphicon-menu-up\"></span>
    <script>
        function backTop(minHeight = 20) {
            \$('.back-top').click(function () {
                \$('html, body').animate({scrollTop: 0}, 200)
            });
            \$(window).scroll(function () {
                var s = \$(window).scrollTop();
                if (s > minHeight) {
                    \$('.back-top').fadeIn().addClass('fadeInRight faster').removeClass('zoomOutRight')
                } else {
                    \$('.back-top').addClass('zoomOutRight').removeClass('fadeInRight faster')
                }
            })
        }

        backTop()
    </script>
</div>
<div class=\"footer-base animated fadeIn delay-1s\">
    {% block footer %}
        &copy; 2017-<span id=\"footer-base-time\"></span>&nbsp;
        <span class=\"glyphicon glyphicon-heart\"></span>&nbsp;{{ about.name }}
        <script>
            let date = new Date;
            let year = date.getFullYear();
            \$('#footer-base-time').text(year);
        </script>
    {% endblock %}
</div>
</body>
</html>", "base.html.twig", "C:\\Users\\ziming\\Project\\www\\EasyBlog\\app\\templates\\base.html.twig");
    }
}
