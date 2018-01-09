$(function(){
//以下为图片放大功能
    function getEventObject(W3CEvent) { //事件标准化函数
        return W3CEvent || window.event;
    }
    function getPointerPosition(e) { //兼容浏览器的鼠标x,y获得函数
        e = e || getEventObject(e);
        var x = e.pageX || (e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft));
        var y = e.pageY || (e.clientY + (document.documentElement.scrollTop || document.body.scrollTop));
        return { 'x':x,'y':y };
    }
    function setOpacity(elem,level) { //兼容浏览器设置透明值
        if(elem.filters) {
            elem.style.filter = 'alpha(opacity=' + level * 100 + ')';
        } else {
            elem.style.opacity = level;
        }
    }
    function css(elem,prop) { //css设置函数,可以方便设置css值,并且兼容设置透明值
        for(var i in prop) {
            if(i == 'opacity') {
                setOpacity(elem,prop[i]);
            } else {
                elem.style[i] = prop[i];
            }
        }
        return elem;
    }
    var magnifier = {
        m: null,
        init: function (magni) {
            var m = this.m = magni || {
                    cont: null,    //装载原始图像的div
                    img: null,      //放大的图像
                    mag: null,      //放大框
                    scale:10,      //比例值,设置的值越大放大越大,但是这里有个问题就是如果不可以整除时,会产生些很小的白边,目前不知道如何解决
                }
            css(m.img, {
                'position': 'absolute',
                'width': (m.cont.clientWidth * m.scale) + 'px', //原始图像的宽*比例值
                'height': (m.cont.clientHeight * m.scale) + 'px' //原始图像的高*比例值
            })
            css(m.mag, {
                'display': 'none',
                'width': m.cont.clientWidth + 'px',      //m.cont为原始图像,与原始图像等宽
                'height': m.cont.clientHeight + 'px',
                'position': 'absolute',
                'left': m.cont.offsetLeft + m.cont.offsetWidth + 10 + 'px', //放大框的位置为原始图像的右方远10px
                'top': m.cont.offsetTop + 'px'
            })
            var borderWid = m.cont.getElementsByTagName('div')[0].offsetWidth - m.cont.getElementsByTagName('div')[0].clientWidth; //获取border的宽
            css(m.cont.getElementsByTagName('div')[0], {      //m.cont.getElementsByTagName('div')[0]为浏览框
                'display': 'none',                //开始设置为不可见
                'width': m.cont.clientWidth / m.scale - borderWid + 'px', //原始图片的宽/比例值 - border的宽度
                'height': m.cont.clientHeight / m.scale - borderWid + 'px', //原始图片的高/比例值 - border的宽度
                'opacity': 0.5          //设置透明度
            })
            m.img.src = m.cont.getElementsByTagName('img')[0].src;      //让原始图像的src值给予放大图像
            m.cont.style.cursor = 'crosshair';
            m.cont.onmouseover = magnifier.start;
        },
        start: function (e) {
            if (document.all) { //只在IE下执行,主要避免IE6的select无法覆盖
                magnifier.createIframe(magnifier.m.img);
            }
            this.onmousemove = magnifier.move; //this指向m.cont
            this.onmouseout = magnifier.end;
        },
        move: function (e) {
            var pos = getPointerPosition(e); //事件标准化
            this.getElementsByTagName('div')[0].style.display = '';
            css(this.getElementsByTagName('div')[0], {
                'top': Math.min(Math.max(pos.y - this.offsetTop - parseInt(this.getElementsByTagName('div')[0].style.height) / 2, 0), this.clientHeight - this.getElementsByTagName('div')[0].offsetHeight) + 'px',
                'left': Math.min(Math.max(pos.x - this.offsetLeft - parseInt(this.getElementsByTagName('div')[0].style.width) / 2, 0), this.clientWidth - this.getElementsByTagName('div')[0].offsetWidth) + 'px' //left=鼠标x - this.offsetLeft - 浏览框宽/2,Math.max和Math.min让浏览框不会超出图像
            })
            magnifier.m.mag.style.display = '';
            css(magnifier.m.img, {
                'top': -(parseInt(this.getElementsByTagName('div')[0].style.top) * magnifier.m.scale) + 'px',
                'left': -(parseInt(this.getElementsByTagName('div')[0].style.left) * magnifier.m.scale) + 'px'
            })
        },
        end: function (e) {
            this.getElementsByTagName('div')[0].style.display = 'none';
            magnifier.removeIframe(magnifier.m.img); //销毁iframe
            magnifier.m.mag.style.display = 'none';
        },
        createIframe: function (elem) {
            var layer = document.createElement('iframe');
            layer.tabIndex = '-1';
            layer.src = 'javascript:false;';
            elem.parentNode.appendChild(layer);
            layer.style.width = elem.offsetWidth + 'px';
            layer.style.height = elem.offsetHeight + 'px';
        },
        removeIframe: function (elem) {
            var layers = elem.parentNode.getElementsByTagName('iframe');
            while (layers.length > 0) {
                layers[0].parentNode.removeChild(layers[0]);
            }
        }
    }
    window.onload = function () {
        magnifier.init({
            cont: document.getElementById('magnifier'),
            img: document.getElementById('magnifierImg'),
            mag: document.getElementById('mag'),
            scale: 3
        });
    }
})
//鼠标经过预览图片函数
function preview(img){
	$("#magnifier  img").attr("src",$(img).attr("src"));
	$("#magnifierImg").attr("src",$(img).attr("src"));
	//$("#magnifier  img").attr("jqimg",$(img).attr("bimg"));
}
//图片预览小图移动效果,页面加载时触发
$(function(){
    var cover  = $("#img").attr('src');//封面图
	//下一张
	$(".spec-scroll .next").bind("click",function(){
        var length = $(".items ul li").length;//缩略图数量
        var view  = $("#img").attr('src');//目前显示的图片
		var num = 0;
        for (var i=0;i<length;i++){
           var img = $(".items ul .jane_img").eq(i).attr('src');
           if(view == img ){//大图显示的是缩略图中的某张
           	   if((length-1)>i){//不是最后一张缩略图
                   var img = $(".items ul .jane_img").eq(i+1).attr('src');
                   $("#magnifier img").attr("src",img);
                   $("#magnifierImg").attr("src",img);
			   }else{//是最后一张缩略图;显示封面图
                   $("#magnifier img").attr("src",cover);
                   $("#magnifierImg").attr("src",cover);
			   }
               break;
		   }else{
               num++
		   }
	    }
        if(num==length){//大图显示的封面图 默认走缩略图第一张
            var img = $(".items ul .jane_img").eq(0).attr('src');
            $("#magnifier  img").attr("src",img);
            $("#magnifierImg").attr("src",img);
        }
	});
	//上一张
	$(".spec-scroll .prev").bind("click",function(){
        var length = $(".items ul li").length;//缩略图数量
        var view  = $("#img").attr('src');//目前显示的图片
        var num = 0;
        for (var j=0;j<length;j++){
            var img = $(".items ul .jane_img").eq(j).attr('src');
            if(view == img ){//大图显示的是缩略图中的某张
                if(j > 0){//不是第一张缩略图
                    var img = $(".items ul .jane_img").eq(j-1).attr('src');
                    $("#magnifier  img").attr("src",img);
                    $("#magnifierImg").attr("src",img);
                }else{//是第一张缩略图;显示封面图
                    $("#magnifier img").attr("src",cover);
                    $("#magnifierImg").attr("src",cover);
                }
                break;
            }else{
                num++
            }
        }

	});
})
	/*点击增加减少商品*/
            function number(){
                var Input0=document.getElementById('input0');
                var Input1=document.getElementById('input1');
                var Input2=document.getElementById('input2');
                var good_count =$("#input0").attr('max');
                var count = $("#input0").val();
				Input1.onclick=function(){
					if(good_count>count){
						count++
						$("#input0").val(count);
					}
				}
				Input2.onclick=function() {
                    if (Input0.value > 1) {
                        count--
                        $("#input0").val(count);
                    }
                }
            }
            number();
//              选项卡
           $(function() {
                var titles = document.getElementById('h_sp3').getElementsByTagName('span');
                var divs = document.getElementById('h_xxk').getElementsByClassName('stencil_img');
                var commentcss = $("#css").val();//点击分页数保留原来的样式
                var average = $("#average").val();//评价星数平均数
                var right = 595-112*average;//指针移动的位置
                if(titles.length != divs.length)
                    return;
                for(var i = 0; i < titles.length; i++) {
                    titles[i].id = i;
                    titles[i].onclick = function() {
                        for(var j = 0; j < titles.length; j++) {
                            titles[j].className = '';
                            divs[j].style.display = 'none';
                        }
                        titles[this.id].className = 'red';
                        divs[this.id].style.display = 'block';
                    }
                }
                //指针移动的位置
                $(".mobel").css('right',right);
                //点击分页时的样式
               if(commentcss !=undefined) {
                   if (commentcss != "kong") {
                       if (commentcss === "img") {
                           $(".radioimg").attr('checked', 'checked');
                       }
                       titles[2].className = "red";
                       divs[2].style.display = 'block';
                       titles[0].className = "";
                       divs[0].style.display = 'none';
                       titles[1].className = "";
                       divs[1].style.display = 'none';
                   }
               }
			})
