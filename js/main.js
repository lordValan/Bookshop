var globalExpandedHeight;

$(window).on('load', function () {
  /* sign 'sale-timer' on 'saleTimerFunc' event every 1 sec */
  if ($('.sale-timer').length > 0)
    setInterval(saleTimerFunc, 1000);

  $('#preloader-block').fadeOut('slow');
});

$(document).ready(function () {
  /* Variables for sliders */
  var prevArr = '<button class="slick-prev slick-arrow"><i class="ti-angle-left"></i></button>',
    nextArr = '<button class="slick-next slick-arrow"><i class="ti-angle-right"></i></button>',
    toprated_bestsellers_books_slick = {
      prevArrow: prevArr,
      nextArrow: nextArr,
      slidesToShow: 6,
      slidesToScroll: 1,
      infinite: false,
      responsive: [
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 4
          }
        },
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 5
          }
        },
      ]
    };

  /* Setting headers for AJAX requests */
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  /* window resize */
  $(window).resize(function() {
    if($(window).width() > 768 && $('.header-form-search').is(':hidden')){
      $('.header-form-search').css('display', 'block');
    }
  });

  /* sign 'header-menu-btn' on 'toggleMenu' event */
  $('.header-menu-btn').click(toggleMenu);

  /* sign 'header-search-btn' on 'toggleSearch' event */
  $('.header-search-btn').click(toggleSearch);

  /* sign 'header-form-search-close-btn' on 'searchFormClose' event */
  $('.header-form-search-close-btn').click(searchFormClose);

  /* sign 'sign-in-btn' on 'signInBtClick' event */
  $('.sign-in-btn').click(signInBtClick);

  /* sign 'sign-up-btn' on 'signUpBtClick' event */
  $('.sign-up-btn').click(signUpBtClick);

  /* sign 'modal-close' on 'hideModalAuth' event */
  $('.modal-close').click(hideModalAuth);

  /* sign 'header-input-search' on 'findThreeBooks' event */
  $('.header-input-search').on('input', findThreeBooks);

  /* sign 'header-input-search' on 'searchInputLostFocus' event */
  $('.header-input-search').blur(searchInputLostFocus)

  /* sign 'main-slider-newest-books-block' on 'newest_books_slick' event */
  if ($('.main-slider-newest-books-block').length > 0)
    $('.main-slider-newest-books-block').slick(newest_books_slick);

  /* sign 'main-slider-bestsellers-container' on 'toprated_bestsellers_books_slick' event */
  if ($('.main-slider-bestsellers-container').length > 0)
    $('.main-slider-bestsellers-container').slick(toprated_bestsellers_books_slick);

  /* sign 'main-slider-toprated-container' on 'toprated_bestsellers_books_slick' event */
  if ($('.main-slider-toprated-container').length > 0)
    $('.main-slider-toprated-container').slick(toprated_bestsellers_books_slick);

  /* sign 'main-sale-books' on 'toprated_bestsellers_books_slick' event */
  if ($('.main-sale-books').length > 0)
    $('.main-sale-books').slick(toprated_bestsellers_books_slick);

  /* sign 'main-author-books-container' on 'toprated_bestsellers_books_slick' event */
  if ($('.main-author-books-container').length > 0)
    $('.main-author-books-container').slick(toprated_bestsellers_books_slick);

  /* sign '.singlebook-container .book-description' on 'changeBookDescrSize' event */
  if ($('.singlebook-container .book-description').length > 0)
    changeBookDescrSize();

  /* sign 'bt-delete-item' on 'deleteCartItem' event */
  if ($('.bt-delete-item').length > 0)
    $('.bt-delete-item').click(deleteCartItem);

  /* sign '.singlebook-container .showMoreLessBt' on 'showMoreOrLessDescription' event */
  if ($('.singlebook-container .showMoreLessBt').length > 0)
    $('.singlebook-container .showMoreLessBt').click(showMoreOrLessDescription);

  /* sign 'btnMinusAmount' on 'booksAmountDown' event */
  if ($('.btnMinusAmount').length > 0)
    $('.btnMinusAmount').click(booksAmountDown);

  /* sign 'btnPlusAmount' on 'booksAmountUp' event */
  if ($('.btnPlusAmount').length > 0)
    $('.btnPlusAmount').click(booksAmountUp);

  /* sign 'main-customer' on 'customerClick' event */
  if ($('.main-customer').length > 0)
    $('.main-customer').click(customerClick);

  /* sign 'btnAddToCart' on 'addToCart' event */
  $('.btnAddToCart').click(addToCart);

  /* set 'user-rating' stars */
  if ($('.user-rating').length > 0) {
    $('.user-rating').each(function () {
      setBarratingRead(this, parseInt($(this).data('book-rating')));
    })
  }

  /* set #book-rating stars */
  if ($('#book-rating').length > 0)
    setBarratingRead($('#book-rating'), parseFloat($('#book-rating').data('book-rating')));

  /* sign 'leave-review-textarea' on 'reviewTextFocusout' event */
  if ($('.leave-review-textarea').length > 0)
    $('.leave-review-textarea').focusout(reviewTextFocusout);

  /* sign 'leave-review-bt-publish' on 'addUserReview' event */
  if ($('.leave-review-bt-publish').length > 0)
    $('.leave-review-bt-publish').click(addUserReview);
})

/* handler for leaving search input */
function searchInputLostFocus(e) {
  if ($(e.relatedTarget).hasClass('found-book-link') || $(e.relatedTarget) == null)
    return;

  $('.search-result-container').hide();
}

/* function for closing search form */
function searchFormClose(){
  $('.header-form-search').fadeOut();
}

/* function for toggle menu */
function toggleMenu(){
  $('.header-menu-block').slideToggle();
}

/* function for toggle search form */
function toggleSearch(){
  $('.header-form-search').fadeIn();
}

/* function for creating found book */
function createFoundBook(book) {
  var bookLink = $("<a href=\"/books/" + book['id'] + "\" class=\"found-book-link\"></a>");

  var foundBookCont = $("<div class=\"found-book flexible\"></div>");

  var foundBookInfo = $("<div class=\"found-book-info\"></div>");
  var foundBookTitle = $("<h3 class=\"title\"></h3>");
  var foundBookAuthor = $("<p class=\"author\"></p>");
  foundBookTitle.text(book['title']);
  foundBookAuthor.text(book['author']);
  foundBookInfo.append(foundBookTitle);
  foundBookInfo.append(foundBookAuthor);

  foundBookCont.append(foundBookInfo);
  bookLink.append(foundBookCont);

  $('.search-result-container').append(bookLink);
}

/* function for setting barrating in read state */
function setBarratingRead(bars, rate) {
  $(bars).barrating({
    theme: 'fontawesome-stars-o',
    initialRating: rate,
    readonly: true
  })
}

/* function for setting barrating in rate state */
function setBarratingRate(bars, bookId) {
  $(bars).barrating({
    theme: 'fontawesome-stars-o',
    onSelect: function (value) {
      setRateAjax(value, bookId, bars)
    }
  })
}

/* click customer function */
function customerClick() {
  if ($(this).hasClass('main-customer-active')) {
    return;
  }

  $('.main-customers-text').hide();
  $('.main-customer-active').removeClass('main-customer-active');
  $(this).addClass('main-customer-active');
  $('.main-customers-text').text($(this).find('.customer-comment').text());
  $('.main-customers-text').fadeIn('slow');
}

/* function for changing book description size */
function changeBookDescrSize() {
  var descr = $('.singlebook-container .book-description');
  globalExpandedHeight = descr.height();

  if (globalExpandedHeight < 200) {
    $('.showMoreLessBt').hide();
  } else {
    descr.height('200px');
  }
}

/* set bg color for newest books slider */
function newestBookSlidesBg() {
  var slides = $('.newest-book-slide');

  for (var i = 0; i < slides.length; i++) {
    var img = $(slides[i]).find('img')[0];
    $(slides[i]).css('background-color', getRGBA(img, 0.85));
  }
}

/* function for showing more or less book description */
function showMoreOrLessDescription() {
  var descr = $('.singlebook-container .book-description');
  if (descr.hasClass('fold')) {
    descr.removeClass('fold');
    descr.addClass('expanded');
    descr.animate({
      height: globalExpandedHeight
    });
    $(this).text('View Less');
  } else {
    descr.removeClass('expanded');
    descr.addClass('fold');
    descr.animate({
      height: '200px'
    });
    $(this).text('View More');
  }
}

/* handler for sign in button click */
function signInBtClick() {
  $('.registration-window').css('display', 'none');
  $('.login-window').css('display', 'block');
}

/* handler for sign up button click */
function signUpBtClick() {
  $('.registration-window').css('display', 'block');
  $('.login-window').css('display', 'none');
}

/* handler for showing modal window for authentication */
function showModalAuth() {
  $('.modal-auth').fadeIn();
}

/* handler for hiding modal window for authentication */
function hideModalAuth() {
  $('.modal-auth').fadeOut();
}

/* handler for hiding modal window for authentication */
function hideShowUserMenu() {
  $('.user-menu').fadeToggle();
}

/* handler for changing book amount in cart */
function booksAmountUp() {
  $(this).siblings('.addBooksAmount')[0].stepUp();
  changeBookInCartAmountDB($(this).siblings('.addBooksAmount')[0]);
}

/* handler for changing book amount in cart */
function booksAmountDown() {
  $(this).siblings('.addBooksAmount')[0].stepDown();
  changeBookInCartAmountDB($(this).siblings('.addBooksAmount')[0]);
}

/* sale timer handler */
function saleTimerFunc() {
  var to = new Date("February 1 2018 00:00:00");
  var now = Date.now();
  var remaining = (to - now) / 1000;

  var days = parseInt(remaining / 86400);
  remaining = remaining % 86400;
  var hours = parseInt(remaining / 3600);
  remaining = remaining % 3600;
  var minutes = parseInt(remaining / 60);
  remaining = parseInt(remaining % 60);

  var timer = $('.sale-timer');
  timer.find('.sale-timer-days>.timer-num').text(days < 10 ? 0 + days.toString() : days);
  timer.find('.sale-timer-hours>.timer-num').text(hours < 10 ? 0 + hours.toString() : hours);
  timer.find('.sale-timer-minutes>.timer-num').text(minutes < 10 ? 0 + minutes.toString() : minutes);
  timer.find('.sale-timer-seconds>.timer-num').text(remaining < 10 ? 0 + remaining.toString() : remaining);
}

/* handler for writting review */
function writeUserReview() {
  $('.leave-review-message').toggle();
  $('.leave-review-user-name').slideToggle();
  $('.leave-review-text-bt').slideToggle();
  $('.leave-review-textarea').trigger('focus');
}

/* handler for leaving review input */
function reviewTextFocusout() {
  if ($(this).val() == '') {
    $('.leave-review-user-name').toggle();
    $('.leave-review-message').slideToggle();
    $('.leave-review-text-bt').slideToggle();
  }
}

/* handler creating review object */
function createReview(data) {
  var review = $("<div class=\"review flexible\"></div>")

  var photo_block = $("<div class=\"photo-block\"></div>")
  var userLink = $("<a href=\"#\"></a>")
  $(userLink).append($('.leave-review-photo-container > img').clone());
  $(photo_block).append(userLink);
  $(review).append(photo_block);

  var text_block = $("<div class=\"text-block\"></div>");
  var review_head_rate = $("<div class=\"review-head-rate flexible\"></div>");
  var user_name = $("<h3 class=\"review-user-head\"></h3>").text($('.leave-review-user-name').text());
  review_head_rate.append(user_name);

  if (data['rate'] > 0) {
    var rating_block = $("<div class=\"rating-block flexible\"></div>");
    var spanRate = $("<span class=\"review-rating\"></span>").text('Rated it');
    var rating_select = $("<select class=\"user-rating\"></select>");
    for (var i = 1; i <= 5; i++) {
      rating_select.append($("<option value=\"" + i + "\"></span>").text(i));
    }

    rating_block.append(spanRate);
    rating_block.append(rating_select);
    setBarratingRead(rating_select, data['rate']);
    review_head_rate.append(rating_block);
  }

  text_block.append(review_head_rate);
  var dt = $("<p class=\"review-date\"></p>").text(data['date']);
  var rev = $("<p class=\"review-content\"></p>").text(data['text']);
  text_block.append(dt);
  text_block.append(rev);
  $(review).append(text_block);

  $('.reviews').append(review);
}

/* handler for changing books amount in cart db */
function changeBookInCartAmountDB(nud) {
  var tr = $(nud).parent().parent().parent();
  $.ajax({
    url: "/cartitems/" + $(tr).data('itemid'),
    dataType: 'json',
    type: 'PUT',
    data: {
      '_method': 'PUT',
      '_token': $('meta[name="csrf-token"]').attr('content'),
      'cart_item_id': $(tr).data('itemid'),
      'amount': $(nud).val()
    },
    success: function (data) {
      tr.find('.total-item-price').text(data['item_total_price'] + '$')
      $('.total-price > b').text(data['total_price'] + '$');
      if (data['items_amount'] > 0)
        $('.items_amount').text(data['items_amount']);
      else
        $('.items_amount').hide();
    },
    error: function (data) {
      /*  */
    }
  });
}

/* handler for deleting book in cart */
function deleteCartItem() {
  var tr = $(this).parent().parent();
  $.ajax({
    url: "/cartitems/" + $(tr).data('itemid'),
    dataType: 'json',
    type: 'DELETE',
    data: {
      'cart_item_id': $(tr).data('itemid'),
      '_method': 'DELETE',
      '_token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (data) {
      tr.hide('fast');
      $('.total-price > b').text(data['total_price'] + '$');
      if (data['items_amount'] > 0){
        $('.items_amount').text(data['items_amount']);
        if ($('#btGoToCheckout').css('display') == 'none') $('#btGoToCheckout').show();
      }      
      else {
        $('.items_amount').hide();
        $('#btGoToCheckout').hide();
      }

    },
    error: function (data) {
     /*  */
    }
  });
}

/* handler for adding book in cart */
function addToCart(e) {
  e.preventDefault();

  var postData = {
    book_id: $(this).data('bookid')
  }

  $.ajax({
    type: "POST",
    url: "/cartitems/" + $(this).data('bookid'),
    dataType: 'JSON',
    data: {
      "_method": 'POST',
      '_token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (data) {
      if(data['result'] == 3){
        showModalAuth();
        return;
      }

      if (data['items_amount'] > 0) {
        $('.items_amount').text(data['items_amount']);
        if ($('.items_amount').css('display') == 'none') {
          $('.items_amount').show();
        }
      } else
        $('.items_amount').hide();
    },
    error: function (data) {
      /*  */
    }
  });
}

/* handler for searching three books */
function findThreeBooks() {
  if($( window ).width() < 768){
    return;
  }

  $.ajax({
    type: "GET",
    url: "/findthree",
    dataType: 'JSON',
    data: {
      "_method": 'GET',
      "query": $(this).val()
    },
    success: function (data) {
      if ($('.search-result-container').css('display') == 'none') {
        $('.search-result-container').show();
      }

      $('.search-result-container').empty();

      if (data.length > 0) {
        for (var i = 0; i < data.length; i++) {
          createFoundBook(data[i]);
        }
        $('.found-book-link').blur(function (e) {
          if ($(e.relatedTarget).hasClass('header-input-search') || $(e.relatedTarget).hasClass('found-book-link') || $(e.relatedTarget) == null)
            return;

          $('.search-result-container').hide();
        })
      } else {
        $('.search-result-container').append($('<p class=\"not-found\">Nothing was found!</p>'));
      }
    },
    error: function (data) {
      /*  */
    }
  })
}

/* handler for adding user review */
function addUserReview() {
  var rev = $('.leave-review-textarea').val();

  if (rev.length == 0)
    return;

  $.ajax({
    type: "POST",
    url: "/reviews/" + $(this).data('bookid'),
    dataType: 'JSON',
    data: {
      "_method": 'POST',
      '_token': $('meta[name="csrf-token"]').attr('content'),
      'review': rev
    },
    success: function (data) {
      if (data['result'] == 2) {
        $('.leave-review-textarea').val('');
        $('.leave-review-textarea').trigger('focusout');
        createReview(data);
        $('.leave-review-block').fadeOut();
      }
    },
    error: function (data) {
      /*  */
    }
  });
}

/* handler for setting book rating */
function setRateAjax(value, bookId, bars) {
  $.ajax({
    url: "/ratings/" + bookId,
    dataType: 'json',
    type: 'POST',
    data: {
      'value': value,
      '_method': 'POST',
      '_token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (data) {
      if (data['result'] == 2) {
        $(bars).barrating('readonly', true);
        $('#book-rating').barrating('destroy');
        setBarratingRead($('#book-rating'), parseFloat(data['average']));
        $('#book-reviews-amount').text(data['amount'] + ' reviews');
      }
    },
    error: function (data) {
      /*  */
    }
  });
}