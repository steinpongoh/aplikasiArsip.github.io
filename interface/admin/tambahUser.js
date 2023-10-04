let tambahUser = document.getElementById('tambahDataUser')
let tambahButton = document.getElementById('tambahButton')
let close = document.getElementById('close')


tambahUser.addEventListener('click',function(){
    document.querySelector('.userPopupBackground').style.display="flex"
})

tambahButton.addEventListener("click", function(){
    document.querySelector('.userPopupBackground').style.display="none"
})

close.addEventListener("click", function(){
    document.querySelector('.userPopupBackground').style.display="none"
})

close.addEventListener('click',function(){
    document.querySelector('.userPopupBackground').style.display="none"
})
