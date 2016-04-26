// fastLiveFilter jQuery plugin 1.0.3
// Copyright (c) 2011, Anthony Bush
// License: <http://www.opensource.org/licenses/bsd-license.php>
// Project Website: http://anthonybush.com/projects/jquery_fast_live_filter/
jQuery.fn.fastLiveFilter=function(e,t){t=t||{};e=jQuery(e);var n=this;var r=t.timeout||0;var i=t.callback||function(){};var s;var o=e.children();var u=o.length;var a=u>0?o[0].style.display:"block";i(u);n.change(function(){var e=n.val().toLowerCase();var t;var r=0;for(var s=0;s<u;s++){t=o[s];if((t.textContent||t.innerText||"").toLowerCase().indexOf(e)>=0){if(t.style.display=="none"){t.style.display=a}r++}else{if(t.style.display!="none"){t.style.display="none"}}}i(r);return false}).keydown(function(){clearTimeout(s);s=setTimeout(function(){n.change()},r)});return this}