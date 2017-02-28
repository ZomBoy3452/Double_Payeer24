<?php if(!defined('ADMIN_SIBHYIP_'.$admintoken)){
echo ('Выявлена попытка взлома!');
exit();
}

//if(empty($id) OR $login!=$adminname){die();}
/**//**//**//**//**//**//**//**//**//**//**/
?>
<div align='center'>		
<table>
	<tr>	
		<td>
<a href="http://alexa.com/data/details/traffic_details?url=<?=$host?>" target="_blank" rel="nofollow"><img id="alexaGraph" src="http://traffic.alexa.com/graph?w=410&amp;h=150&amp;o=f&amp;c=1&amp;y=t&amp;b=ffffff&amp;n=666666&amp;r=3m&amp;u=<?=$host?>" width="410" border="0"></a>		
<!--<br>http://www.alexa.com/siteinfo/<?=$host?><br>-->	

<?if($http_s=='http'){?>
<a href="http://www.alexa.com/siteinfo/<?=$host?>"><script type="text/javascript" src="http://xslt.alexa.com/site_stats/js/s/a?url=<?=$host?>"></script></a>
<?}?>
<br>	

<script type="text/javascript">
/*
    custom site traffic widget (js, html5 canvas, yandex metrika)
    v.0.9.0 d.26.03.2014
    v.0.9.2 d.08.04.2014
    v.0.9.3 d.14.04.2014
    author: michael verhov
    http://michael.verhov.com/en/post/site_traffic_widget
    license: GNU GPL
*/

(function (window, document) {

    // informer
    var $informer = function (canvas_selector, custom_settings) {
        if (window === this) {
            return new $informer(canvas_selector, custom_settings);
        }

        // canvas select
        var canvas;
        if (typeof canvas_selector === 'string')
            canvas = document.getElementById(canvas_selector);
        else
            throw new Error('canvas selector must be specified');

        if ((canvas == null) || (canvas.localName !== 'canvas'))
            throw new Error('selector must point to canvas');

        this.width = canvas.width;
        this.height = canvas.height;

        var context = canvas.getContext('2d');
        var g_container = [];

        // default settings
        var settings = {
            font: '10px Sans-Serif',
            fontColor: '#97A9B2',

            hintBg: '#A3B3BB',
            hintTextColor: '#fff',
            hintScale: 120,

            showCaption: false,  // ~ caption, x, y, color, grid colors
            caption: 'metrika.yandex.com',
            showGrid: false,
            showDayOfWeek: true,
            weekDays: new Array('su', 'mo', 'tu', 'we', 'th', 'fr', 'sa'),
            showDaysOfMonth: false
        };

        // extend default settings
        if (custom_settings != undefined)
            $informer.extend(settings, custom_settings);
        this.settings = settings;

        // graphic objects
        this.hintFunc = function (ctx, x, y, text) {
            ctx.fillStyle = settings.hintBg;
            ctx.fillRect(x - 16, y - 16, 32, 11);   // ~ text length

            // triangle
            ctx.beginPath();
            ctx.moveTo(x-4, y-6);
            ctx.lineTo(x, y-2);//bottom
            ctx.lineTo(x+4, y-6);
            ctx.fill();

            ctx.fillStyle = settings.hintTextColor;
            ctx.font = settings.font;
            ctx.textAlign = 'center';   //ctx.textBaseline = 'top';
            ctx.fillText(text, x, y - 7);
        }
        this.gObjects = (function (hint) {
            return {
                Circle: function (params) {
                    this.x = 0;
                    this.y = 0;
                    this.radius = 4;
                    this.bg = '#f5f5f5';    //A3B3BB
                    this.showHint = false;
                    this.hintText = '?';
                    this.stroke = true;
                    this.strokeWidth = 0.5;
                    this.strokeColor = '#aaa';

                    $informer.extend(this, params);

                    this.hintScale = params.hintScale !== undefined ?
                        Math.pow(params.hintScale / 100 * this.radius, 2) :
                        Math.pow(this.radius, 2);

                    this.Draw = function (ctx, mx, my) {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                        ctx.closePath();
                        ctx.fillStyle = this.bg;
                        ctx.fill();
                        if (this.stroke === true) {
                            ctx.lineWidth = this.strokeWidth;
                            ctx.strokeStyle = this.strokeColor;
                            ctx.stroke();
                        }

                        // mouse hover
                        if (this.showHint === true)
                            if (Math.pow(mx - this.x, 2) + Math.pow(my - this.y, 2) < (this.hintScale))
                                hint(ctx, this.x, this.y, this.hintText);
                    }

                },
                MultiLine: function (params) {
                    this.path = [[]];
                    this.width = 0.5;
                    this.color = '#bbb';

                    $informer.extend(this, params);

                    this.Draw = function (ctx) {
                        if (this.path.length === 0)
                            return;

                        ctx.lineWidth = this.width;
                        ctx.strokeStyle = this.color;

                        ctx.beginPath();
                        ctx.moveTo(this.path[0][0], this.path[0][1]);
                        for (var i = 0; i < this.path.length - 1; i++) {
                            ctx.lineTo(this.path[i + 1][0], this.path[i + 1][1]);
                        }
                        //ctx.closePath();
                        ctx.stroke();
                    }
                },
                Grid: function (params) {
                    this.height = canvas.height;
                    this.width = canvas.width;
                    this.cellWidth = 10;
                    this.cellHeight = 10;
                    this.color = '#ccc';
                    this.lineWidth = 0.2;

                    $informer.extend(this, params);

                    this.xDiv = (this.width / this.cellWidth);
                    this.yDiv = (this.height / this.cellHeight);

                    this.Draw = function (ctx) {
                        ctx.lineWidth = this.lineWidth;
                        ctx.strokeStyle = this.color;
                        ctx.beginPath();
                        for (var i = 1; i < this.xDiv; i++) {
                            ctx.moveTo(this.cellWidth * i, 0);
                            ctx.lineTo(this.cellWidth * i, this.height);
                            ctx.closePath();
                        }
                        for (var j = 1; j < this.yDiv; j++) {
                            ctx.moveTo(0, this.cellHeight * j);
                            ctx.lineTo(this.width, this.cellHeight * j);
                            ctx.closePath();
                        }
                        ctx.stroke();
                    }
                },
                Text: function (params) {
                    this.x = 0;
                    this.y = 0;
                    this.font = '9px Sans-Serif';
                    this.color = '#ccc';
                    this.align = 'left';
                    this.text;

                    $informer.extend(this, params);

                    this.Draw = function (ctx) {
                        ctx.fillStyle = this.color;
                        ctx.font = this.font;
                        ctx.textAlign = this.align;   //ctx.textBaseline = 'top', 'middle';
                        ctx.fillText(this.text, this.x, this.y);
                    }
                }
            }
        })(this.hintFunc);

        // add grid
        if (settings.showGrid === true)
            g_container.push(new this.gObjects.Grid({ cellWidth: 10, cellHeight: 10 }));

        // add caption
        if (settings.showCaption === true)
            g_container.push(new this.gObjects.Text({ text: this.settings.caption, x: this.width - 3, y: this.height - 2, color: '#cacaca', align: 'right' }));

        // redraw graphic function
        this.redraw = function (mx, my) {
            context.clearRect(0, 0, canvas.width, canvas.height);
            for (var i = 0; i < g_container.length; i++)
                g_container[i].Draw(context, mx, my);
        }
        this.push_obj = function (g_obj) {
            g_container.push(g_obj);
        }

        // canvas mouse move function
        canvas.onmousemove = (function (redraw) {
            return function (e) {
                redraw(e.offsetX || e.layerX - e.currentTarget.offsetLeft, e.offsetY || e.layerY - e.currentTarget.offsetTop);
            };
        })(this.redraw);

        // other help functions
        this.isWeekend = function (dayOfWeek) {
            return (dayOfWeek === 6 || dayOfWeek === 0) ? true : false;
        }
        this.subtractDow = function (day) {
            var r_day = day - 1;
            if (r_day === -1)
                r_day = 6;
            return r_day;
        }

        return this;
    };

    $informer.fn = $informer.prototype = {
        showStat: function (graphType, data, styles) {
            // current date
            if (data.current_date === undefined)
                data.current_date = new Date();

            // add days captions
            if (this.settings.showDayOfWeek || this.settings.showDaysOfMonth) {
                var current_date = new Date(data.current_date),
                    current_day = data.current_date.getDay(),
                    col_width = this.width / Math.max(data.pageviews.length, data.uniques.length),
                    col_offset = col_width / 2;

                for (var i = data.pageviews.length - 1; i >= 0 ; i--) {
                    // add day of week caption
                    if (this.settings.showDayOfWeek === true)
                        this.push_obj(new this.gObjects.Text({ text: this.settings.weekDays[current_day], align: 'center', x: col_offset + col_width * i, y: this.height - 3, color: '#cacaca' }));

                    // add day of month caption
                    if (this.settings.showDaysOfMonth === true) {
                        this.push_obj(new this.gObjects.Text({ text: current_date.getDate(), align: 'center', x: col_offset + col_width * i, y: this.height - 3, color: '#ccc', font: '9px Sans-Serif', }));
                        current_date.setDate(current_date.getDate() - 1);
                    }
                    current_day = this.subtractDow(current_day);
                }
            }

            //build graphic
            this[graphType](data, styles);
            this.redraw();

            return this;
        },
        showYandexStat: function (graphType, counter_id, styles) {
            // [dev note] other variants: xmlh request and eval or add script tag:
            /* <!--script type="text/javascript" src="//bs.yandex.ru/informer/XXXXXX/json"--><!--/script-->*/

            // NOTE: 
            // 1. need to install Yandex counter: https://metrika.yandex.com/
            // 2. activate Informer option (in counter code tab)
            // 3. on Access tab selects: "Show informer information"
            //  . requests should be made from your domain
            var g = graphType, s = styles;

            var sc = document.createElement('script'),
                body = document.getElementsByTagName("body")[0];
            sc.type = 'text/javascript';
            sc.charset = 'utf-8';

            var callback = 'ym' + +new Date;
            sc.src = '<?=$http_s?>://bs.yandex.ru/informer/' + counter_id + '/json?callback=' + callback;    // mc
            body.appendChild(sc);

            window[callback] =
                function (context) {
                    return function (ya_stat) {
                        body.removeChild(sc);
                        if (ya_stat && ya_stat.uniques) {
                            var vDate = new Date();
                            try {
                                var dateArr = ya_stat.current_date.split(' ', 1)[0].split('.');
                                vDate = new Date(dateArr[0], parseInt(dateArr[1], 10) - 1, dateArr[2]);;
                            } catch (e) {
                            }
                            context.showStat(g, { uniques: ya_stat.uniques.reverse(), pageviews: ya_stat.pageviews.reverse(), current_date: vDate }, s);
                        }
                        try {
                            delete window[callback]
                        } catch (ex) {
                            window[callback] = void 0
                        }
                    }
                }(this);
            return this;
            //window[callback]({ uniques: [1, 2, 3, 4, 5, 7, 9, 3, 4, 5, 7, 9], pageviews: [3, 4, 5, 6, 7, 11, 14, 5, 6, 7, 11, 14], current_date: new Date("2014.03.28 10:39:34") });
        },
        redraw: function () {
            this.redraw(-1, -1);
            return this;
        }
    };

    $informer.extend = $informer.fn.extend = function (target, source) {
        if (target != null && source != null) {
            for (name in source) {
                if (source[name] !== undefined) {
                    target[name] = source[name];
                }
            }
        }
        return target;
    }

    window.$informer = $informer;
})(window, document);


$informer.fn.CirclesGraph = function (data, styles) {
    // data: {uniques [], pageviews [],  }
    var def_styles = {
        lineWidth: 0.5,
        lineColor: '#A3B3BB',

        circleRadius: 4,
        circleBg: '#F5F5F5',
        circleBorderColor: '#97A9B2',
        circleBorderWidth: 0.5,

        paintWeekends: true,
        weekendBg: '#DF907C'
    };
    this.extend(def_styles, styles);

    // calculate plot sizes
    var plot_bottom_offset = def_styles.circleRadius + 12,
        plot_top_offset = this.height - 30,    // -20 top offset for hint - bottom offset
        col_width = this.width / Math.max(data.pageviews.length, data.uniques.length),
        col_offset = col_width / 2,
        high_value = Math.max(Math.max.apply(null, data.pageviews), Math.max.apply(null, data.uniques)); // min_value = 0 ~?min

    var pv_line_points = [], u_line_points = [];
    var current_day = data.current_date.getDay();

    // lines
    this.push_obj(new this.gObjects.MultiLine({ path: pv_line_points, width: def_styles.lineWidth, color: def_styles.lineColor }));
    this.push_obj(new this.gObjects.MultiLine({ path: u_line_points, width: def_styles.lineWidth, color: def_styles.lineColor }));

    // pageviews
    for (var i = data.pageviews.length - 1; i >= 0 ; i--) {
        var pv_circle = new this.gObjects.Circle({
            x: col_offset + col_width * i,
            y: this.height - plot_top_offset / (high_value / data.pageviews[i]) - plot_bottom_offset,
            bg: (def_styles.paintWeekends && this.isWeekend(current_day)) ? def_styles.weekendBg : def_styles.circleBg,
            showHint: true,
            hintText: data.pageviews[i].toString(),
            radius: def_styles.circleRadius,
            strokeWidth: def_styles.circleBorderWidth,
            strokeColor: def_styles.circleBorderColor,
            hintScale: this.settings.hintScale
        });

        current_day = this.subtractDow(current_day);
        this.push_obj(pv_circle);
        pv_line_points.push([pv_circle.x, pv_circle.y]);
    }

    // uniques
    for (var i = data.uniques.length - 1; i >= 0 ; i--) {
        var u_circle = new this.gObjects.Circle({
            x: col_offset + col_width * i,
            y: this.height - plot_top_offset / (high_value / data.uniques[i]) - plot_bottom_offset,
            showHint: true, hintText: data.uniques[i].toString(),
            bg: def_styles.circleBg,
            radius: def_styles.circleRadius,
            strokeWidth: def_styles.circleBorderWidth,
            strokeColor: def_styles.circleBorderColor,
            hintScale: this.settings.hintScale
        });
        this.push_obj(u_circle);
        u_line_points.push([u_circle.x, u_circle.y]);
    }

    return this;
}

$informer.fn.BezierGraph = function (data, styles) {
    var def_styles = {
        lineWidth: 0.5,
        uLineColor: '#d01b26',
        pvLineColor: '#006a9f',

        circleRadius: 3,
        circleBg: '#F5F5F5',
        circleBorderWidth: 0.5,

        paintWeekends: true,
        weekendBg: '#5EA2C5'    //E96969-red
    };
    this.extend(def_styles, styles);

    // calculate plot sizes
    var plot_bottom_offset = 9 + def_styles.circleRadius,
        plot_top_offset = this.height - plot_bottom_offset - 16,
        col_width = this.width / Math.max(data.pageviews.length, data.uniques.length),
        col_offset = col_width / 2,
        high_value = Math.max(Math.max.apply(null, data.pageviews), Math.max.apply(null, data.uniques));

    var pv_line_points = [], u_line_points = [];
    var current_day = data.current_date.getDay();

    function SplineLine(params) {
        this.path = [[]];
        this.width = 0.5;
        this.color = '#bbb';

        $informer.extend(this, params);

        this.Draw = function (ctx) {
            if (this.path.length === 0)
                return;

            ctx.lineWidth = this.width;
            ctx.strokeStyle = this.color;
            ctx.beginPath();

            ctx.moveTo(this.path[0][0], this.path[0][1]);
            for (var i = 0; i < this.path.length - 1; i++) {
                var xPoint =  (this.path[i + 1][0] - this.path[i][0]) / 2 + this.path[i][0];
                ctx.bezierCurveTo(xPoint, this.path[i][1], xPoint, this.path[i + 1][1], this.path[i + 1][0], this.path[i + 1][1]);
            }
            ctx.stroke();
        }
    }

    // lines
    this.push_obj(new SplineLine({ path: pv_line_points, width: def_styles.lineWidth, color: def_styles.pvLineColor }));
    this.push_obj(new SplineLine({ path: u_line_points, width: def_styles.lineWidth, color: def_styles.uLineColor }));

    for (var i = data.pageviews.length - 1; i >= 0 ; i--) {
        var pv_circle = new this.gObjects.Circle({
            x: col_offset + col_width * i,
            y: this.height - plot_top_offset / (high_value / data.pageviews[i]) - plot_bottom_offset,
            bg: (def_styles.paintWeekends && this.isWeekend(current_day)) ? def_styles.weekendBg : def_styles.circleBg,
            showHint: true, hintText: data.pageviews[i].toString(),
            radius: def_styles.circleRadius,
            strokeWidth: def_styles.circleBorderWidth,
            strokeColor: def_styles.pvLineColor,
            hintScale: this.settings.hintScale
        });

        current_day = this.subtractDow(current_day);
        this.push_obj(pv_circle);
        pv_line_points.push([pv_circle.x, pv_circle.y]);
    }

    for (var i = data.uniques.length - 1; i >= 0 ; i--) {
        var u_circle = new this.gObjects.Circle({
            x: col_offset + col_width * i,
            y: this.height - plot_top_offset / (high_value / data.uniques[i]) - plot_bottom_offset,
            showHint: true, hintText: data.uniques[i].toString(),
            bg: def_styles.circleBg,
            radius: def_styles.circleRadius,
            strokeWidth: def_styles.circleBorderWidth,
            strokeColor: def_styles.uLineColor,
            hintScale: this.settings.hintScale
        });
        this.push_obj(u_circle);
        u_line_points.push([u_circle.x, u_circle.y]);
    }
}
</script>

<canvas id="traffic-widget-ex1" height="70" width="200"></canvas>





<!--  -->
<?
// NOTE: 
// 1. need to install Yandex counter: https://metrika.yandex.com/
// 2. activate Informer option (in counter code tab)
// 3. on Access tab selects: "Show informer information"
//  . requests should be made from your domain
$yandexmetrikaid=33761979;

?>
<script type="text/javascript" src="//bs.yandex.ru/informer/<?=$yandexmetrikaid?>/json"></script>
<script type="text/javascript">
//Виджет Яндекс Метрики:
 $informer("traffic-widget-ex1").showYandexStat("CirclesGraph", "<?=$yandexmetrikaid?>");
</script>	
<!-- Yandex.Metrika counter --><script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter<?=$yandexmetrikaid?> = new Ya.Metrika({ id:<?=$yandexmetrikaid?>, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "<?=$http_s?>://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><!-- /Yandex.Metrika counter -->   	
	
	
	
	
	
	
	
	
	
		</td>
<td>

<br><b>Сайты, с которых пришли зарегистрированные пользователи:</b><br>
<?

//Считаем количество уникальных значений поля came
$sql = "SELECT COUNT(DISTINCT came) AS countid FROM `ss_users`";
$res = $db->query($sql); 
$row=$db->fetch($res);
$maxid=$row["countid"];

//Сколько сайтов выводить на страницу
$limit=20;

//Начальная позиция при смене страницы
$p=(int)$_GET['p'];
if (!empty($_GET['p'])){$start=$limit*$p;}else{$start=0;}

//Количество страниц
$allpages=ceil($maxid/$limit);

$sql = "select came from `ss_users` GROUP BY came ORDER BY came ASC LIMIT ".$start.",".$limit;
$res = $db->query($sql); 
$i=0;
while($row=$db->fetch($res))
{
	$came=$row["came"]; 
		$sql2 = "select count(id) as countid from `ss_users` WHERE came='".$came."'";
		$res2 = $db->query($sql2); 
		$row2=$db->fetch($res2);
		$count=$row2["countid"]; 
						
		
		if($came!='Не определено' AND !empty($came)){
			echo "<a href='http://".$came."/' target='_blank'>".$came." <i>[".$count."]</i></a><br>";
		}else{
			echo $came." <i>[".$count."]</i><br>";
		}
		


		
		
		
		
}
?>&bull;&bull;&bull;<br><?
if($allpages>1){
?>СТРАНИЦА: <?
$i=0;
while($i<$allpages)
{
$p=$i+1;
	echo "<a href='/?page=".$adminadress."&action=traf&p=".$i."'>".$p."</a>&nbsp;";
	$i++;
}
}
?>
	</tr>
</table>
</div>