import $ from 'jquery';
import axios from 'axios';

class Search {
  //Section number 1 we describe and create or iniate our object
  constructor() {
    this.addSearchHtml();
    this.resultsDiv = $('.search-overlay__results');
    this.openButton = $('.js-search-trigger');
    this.closeButton = $('.search-overlay__close');
    this.searchOverlay = $('.search-overlay');
    this.searchField = $('#search-term');
    this.events(); //para que pueda usar los eventos
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;
  }

  //List events

  events() {
    this.openButton.on('click', this.openOverlay.bind(this));
    this.closeButton.on('click', this.closeOverlay.bind(this));
    $(document).on('keydown', this.keyPressDispatcher.bind(this));
    this.searchField.on('keyup', this.typingLogic.bind(this));
  }

  //Methods (functions or actions)

  typingLogic() {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);

      if (this.searchField.val()) {
        if (this.isSpinnerVisible == false) {
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }

        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.resultsDiv.html('');
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = this.searchField.val();
  }

  getResults() {
    $.when(
      $.getJSON(
        universityData.root_url +
          '/wp-json/wp/v2/posts?search=' +
          this.searchField.val()
      ),
      $.getJSON(
        universityData.root_url +
          '/wp-json/wp/v2/pages?search=' +
          this.searchField.val()
      )
    ).then((posts, pages) => {
      var combinedResults = posts[0].concat(pages[0]);
      console.log(combinedResults);
      this.resultsDiv.html(`
    <h2 class="search-overlay__section-title">General Information</h2>
    ${
      combinedResults.length
        ? ' <ul class="link-list min-list">'
        : '<p>No general information matches that search</p>'
    }
    ${combinedResults.length ? '</ul>' : ''}
   
    ${combinedResults
      .map(
        (item) =>
          `<li><a href=${item.link}>${item.title.rendered}</a> ${
            item.type == 'post' ? `by ${item.authorName}` : ''
          } </li>` //no se puede usar if con backtips solo ternary
      )
      .join('')}
    </ul> 
    `);
      this.isSpinnerVisible = false;
    });
  }

  keyPressDispatcher(e) {
    if (e.keyCode == 83 && this.isOverlayOpen == false) {
      this.openOverlay();
      console.log(e.keyCode);
    } else if (e.keyCode == 27 && this.isOverlayOpen == true) {
      this.closeOverlay();
      console.log(e.keyCode);
    }
  }

  openOverlay() {
    this.searchOverlay.addClass('search-overlay--active');
    $('body').addClass('body-no-scroll');
    this.searchField.val('');
    setTimeout(() => this.searchField.trigger('focus'), 301);
    console.log('our open method just ran');

    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.removeClass('search-overlay--active');
    $('body').removeClass('body-no-scroll');
    this.isOverlayOpen = false;
  }

  addSearchHtml() {
    $('body').append(`
    <div class="search-overlay">
  <div class="search-overlay__top">
    <div class="container">
      <i class="fa fa-search search-overlay__icon " aria-hidden="true"></i>
      <input type="text" class="search-term" placeholder="What are you looking form?" id="search-term">
      <i class="fa fa-window-close search-overlay__close " aria-hidden="true"></i>

    </div>

  </div>
  <div class="container">
    <div class="search-overlay__results">
    </div>
  </div>
</div>
    `);
  }
}

export default Search;
