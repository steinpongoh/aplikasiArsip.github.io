// POPUP WINDOW : Create
let tambahButton = document.getElementById('tambah')
let closeTambahButton = document.getElementById('closeTambah')
let tambahKategori = document.getElementById('tambahKategori')
let closeKategoriTambahButton=document.getElementById('closeKategoriTambah');

tambahButton.addEventListener("click",function() {
    document.querySelector('.popup-background').style.display='flex'
})

closeTambahButton.addEventListener("click", function() {
    document.querySelector('.popup-background').style.display='none'
})

tambahKategori.addEventListener("click", function(){
    document.querySelector('.kategoriPopupBackground').style.display="flex"
})

closeKategoriTambahButton.addEventListener("click", function(){
    document.querySelector('.kategoriPopupBackground').style.display='none'
})

let addUserButton = document.getElementById('addUserButton')
addUserButton.addEventListener('mouseover', function(){
    document.querySelector('.userInfo').style.display='flex'
})

addUserButton.addEventListener('mouseleave', function(){
    document.querySelector('.userInfo').style.display='none'
})

let logoutButton = document.getElementById('logoutButton')
logoutButton.addEventListener('mouseover', function(){
    document.querySelector('.logoutInfo').style.display='flex'
})
logoutButton.addEventListener('mouseleave', function(){
    document.querySelector('.logoutInfo').style.display='none'
})