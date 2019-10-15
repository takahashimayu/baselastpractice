'use strict';

window.onload = function() {

    // menuボタンクリック時
    let menuBtn = document.querySelector('.menu-btn');
    let navMenu = document.querySelector('nav');
    menuBtn.addEventListener('click', function(){
        this.classList.toggle('close');
        navMenu.classList.toggle('hide');
    }, false);

    // 表示されているページ名を取得
    let currentPage = document.querySelector('body').getAttribute('class');
    switch(currentPage) {
        case "index":
            // indexページ
            // コメント送信時
            let sendIcon = document.querySelector('.index header i');
            console.log(sendIcon);
            sendIcon.addEventListener('click', function(){
                document.commentfrm.submit();
            }, false);
            break;

        case "wether":
            // wetherページ
            // 都市変更時
            let selectMenu = document.querySelector('.wether header form select');
            selectMenu.addEventListener('change', function(){
                document.cityfrm.submit();
            }, false);
            break;

        case "contact":
            // contactページ
            break;
        }

}

$(function(){
    //　トップへもどるボタンクリック時
    $('h1')
        .click(function(){
            scrollTo(0, 0);
        });
});