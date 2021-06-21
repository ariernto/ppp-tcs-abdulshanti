jQuery(function($){
/* ----------------------------------------------------------- */
/* Slick slider example
/* ----------------------------------------------------------- */  

$("#regular").slick({
	lazyLoad: 'ondemand',
	arrows: true,
	dots: false,
	slidesToShow: 3,
	slidesToScroll: 1,
	autoplay: false,
	autoplaySpeed: 2000,
	responsive: [
		{
			breakpoint: 991,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1,		
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}
	]
});

/* ----------------------------------------------------------- */
/* Slick product slider example
/* ----------------------------------------------------------- */  

/* ----------------------------------------------------------- */
/* modal open close any where only close button will close
/* ----------------------------------------------------------- */  

  $(document).ready(function(){
    $('.launch-modal').click(function(){
      $('.notclose1').modal({
        backdrop: 'static'
      });
    }); 
  });
/* ----------------------------------------------------------- */
/* modal multiple open second remove
/* ----------------------------------------------------------- */  
	
 var text = document.getElementById('text');
        var newDom = '';
        var animationDelay = 6;
        for(let i = 0; i < text.innerText.length; i++)
        {
            newDom += '<span class="char">' + (text.innerText[i] == ' ' ? '&nbsp;' : text.innerText[i])+ '</span>';
        }

        text.innerHTML = newDom;
        var length = text.children.length;

        for(let i = 0; i < length; i++)
        {
            text.children[i].style['animation-delay'] = animationDelay * i + 'ms';
        }
    
/*--------------------------------------------------------------*/
/*text_effect*/
/*--------------------------------------------------------------*/	

/*--------------btn-loader start---------------*/
      $(document).ready(function () {
          $('.has-spinner').click(function () {
              var btn = $(this);
              $(btn).buttonLoader('start');
              setTimeout(function () {
                  $(btn).buttonLoader('stop');
              }, 3000);
          });
      });
 
/*--------------btn-loader end---------------*/
}); 