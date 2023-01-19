// Fungsi untuk Header start yang responsif
var navbarMenu = document.getElementById('menu');
var burgerMenu = document.getElementById('burger');
var bgOverlay = document.getElementById('overlay');

// Buka menu ketika kita klik burger
// Tutup menu ketika kita klik overlay
if (burgerMenu && navbarMenu && bgOverlay) {
  burgerMenu.addEventListener('click', function () {
    navbarMenu.classList.toggle('is-active');
    bgOverlay.classList.toggle('is-active');
    burgerMenu.classList.toggle('burgerMenuChange');
  });
  bgOverlay.addEventListener('click', function () {
    navbarMenu.classList.toggle('is-active');
    bgOverlay.classList.toggle('is-active');
  });
}

// Sembunyikan menu ketika link diklik

document.querySelectorAll('.menu-link').forEach(function (link) {
  link.addEventListener('click', function () {
    navbarMenu.classList.remove('is-active');
    bgOverlay.classList.remove('is-active');
  });
});

// fungsi untuk header end responsif

// Modal PopUp atau Quickview untuk produk start
$(window).ready(function () {
  var init = function () {
    popup();
  };

  var isDone = true;

  var popup = function () {
    var $items = $('.mini-carousel ul');
    // untuk menampilkan popup
    $('.btn-view').on('click', function () {
      $('#quick-view-pop-up').fadeToggle();
      $('#quick-view-pop-up').css({ display: 'flex' });
      $('.mask').fadeToggle();
    });
    // untuk menutup ketika saya mengklik random di luar kotak
    $('.mask').on('click', function () {
      $('.mask').fadeOut();
      $('#quick-view-pop-up').fadeOut();
    });
    // untuk menutup ketika saya mengklik X
    $('.quick-view-close').on('click', function () {
      $('.mask').fadeOut();
      $('#quick-view-pop-up').fadeOut();
    });

    // untuk menggunakan carousel
    //  untuk mengklik sebelum
    $('.prev').on('click', function () {
      // menganimasikan element ul dari gambar kecil di kiri
      if (!isDone) return;
      if ($items.position().top === 0) {
        $items.css({ top: '-125px' });
        $items.children('li').last().prependTo($items);
      }
      isDone = false;
      $('.mini-carousel ul').animate(
        {
          top: '+=125px',
        },
        200,
        function () {
          isDone = true;
        }
      );
      $('.image-large ul li').last().prependTo($('.image-large ul'));
    });

    // untuk setelah
    $('.next').on('click', function () {
      // menganimasikan element ul untuk kelas dari '.mini-carousel'
      if (!isDone) return;
      if ($items.position().top === 0) {
        $items.css({ top: '125px' });
        $items.children('li').first().appendTo($items);
      }
      isDone = false;
      $('.mini-carousel ul').animate({ top: '-=125px' }, 300, function () {
        isDone = true;
      });
      $('.image-large ul li').first().appendTo($('.image-large ul'));
    });
  };
  init();
});
// Modal PopUp atau Quickview untuk produk end

// fungsi untuk Link Active untuk -Filter halaman shop start
const linkColor = document.querySelectorAll('.sidebar-category-link');

function colorLink() {
  linkColor.forEach((l) => l.classList.remove('active-link'));
  this.classList.add('active-link');
}

linkColor.forEach((l) => l.addEventListener('click', colorLink));
// fungsi untuk Link Active untuk -Filter halaman shop End

// fungsi untuk membuka dan menyembunyikan Filter halaman shop start
const showMenu = (toggleId, navbarId) => {
  const toggle = document.getElementById(toggleId);
  const navbar = document.getElementById(navbarId);

  if (toggle && navbar) {
    toggle.addEventListener('click', () => {
      //Memperlihatkan Kategori Sosis
      navbar.classList.toggle('show-menu');
      // change icon ketika menu dibuka
      toggle.classList.toggle('change-icon');
    });
  }
};
showMenu('sidebar-toggle', 'sidebar');
// fungsi untuk membuka dan menyembunyikan Filter halaman shop End

// fungsi untuk slider perubahan harga start
(function () {
  var parent = document.querySelector('.sidebar-filter .range-slider');
  if (!parent) return;

  var rangeS = parent.querySelectorAll('input[type=range]'),
    numberS = parent.querySelectorAll('input[type=number]');

  rangeS.forEach(function (el) {
    el.oninput = function () {
      var slide1 = parseFloat(rangeS[0].value),
        slide2 = parseFloat(rangeS[1].value);

      if (slide1 > slide2) {
        [slide1, slide2] = [slide2, slide1]; //kiri = kanan dan kanan = kiri ketika valuenya equal
        // var tmp = slide2
        // slide2 = slide1;
        // slide1 = tmp
      }

      numberS[0].value = slide1; //input[type=number] ketika value sama dengan input [type=range] ketika discroll
      numberS[1].value = slide2;
    };
  });

  numberS.forEach(function (el) {
    el.oninput = function () {
      var number1 = parseFloat(numberS[0].value),
        number2 = parseFloat(numberS[1].value);

      if (number1 > number2) {
        var tmp = number1;
        numberS[0].value = number2;
        numberS[1].value = tmp;
      }

      rangeS[0].value = number1;
      rangeS[1].value = number2;
    };
  });
})();

// fungsi untuk slider perubahan harga End

// fungsi untuk custom dropdown filter page toko start
// membuka atau menutup drop down
$('.drop-down .selected a').click(function () {
  $('.drop-down .options ul').toggle();
});

// opsi untuk memilih dan menutup setelah seleksi
$('.drop-down .options ul li a').click(function () {
  var text = $(this).html();
  $('.drop-down .selected a span').html(text);
  $('.drop-down .options ul').hide();
});

// menutup dropdown ketika saya menekan dimanapun di halaman
$(document).bind('click', function (e) {
  var $clicked = $(e.target);
  if (! $clicked.parents().hasClass('drop-down'))
    $('.drop-down .options ul').hide();
});

// fungsi untuk custom dropdown filter page toko start
$(function (){
  $(".rateyo").rateYo().on("rateyo.change",function(e, data){

    var rating = data.rating;
    $(this).parent().find('.score').text('score :' + $(this).attr('data-rateyo-score'));
    $(this).parent().find('input[name-rating]').val(rating);

  });
});
// RateYo for Rate End
