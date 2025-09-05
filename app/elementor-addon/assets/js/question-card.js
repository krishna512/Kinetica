/**
 * ===========================================================================
 *  Custom widget handler class
 *  @widget Question Carousel
 * ===========================================================================
 */
class QuestionHandler extends elementorModules.frontend.handlers.Base {
  /**
   * Specifying the jQuery selectors of the HTML elements
   *
   * Runs when the widget is loaded
   */
  getDefaultSettings() {
    return {
      selectors: {
        questionCards: '.questionCards',
        cardYesBtn: '#card-yes-btn',
        cardNoBtn: '#card-no-btn',
        levelCounter: '#level-counter',
        cards: '.questionCards__questions--card',
        restartButton: '.restart__button',
      },
    };
  }

  /**
   * On Init
   *
   * Runs when the widget is loaded and initialized in the frontend.
   */
  onInit() {
    // Call parent onInit method
    super.onInit();

    // Get selectors from settings
    this.selectors = this.getSettings('selectors');

    //card data
    this.card_data = question_card_data.card_data;
    this.ans_yes_card = [];
    this.ans_no_card = [];
    this.score_point = 0;
    this.backup_questionCards = document.querySelectorAll('.questionCards__questions--card');

    // Initialize question count
    this.questionCount = 0;

    // Get reference to question counter element
    this.questionCounter = this.$element.find(this.selectors.levelCounter);

    // 
    this.pass_result_info = this.$element.find('#pass_result_info').text();
    this.fail_result_info = this.$element.find('#fail_result_info').text();

    // Output initial count to console
    // console.log('Example Widget Init');

    this.incrementQuestionCounter();

    // Setup event listeners
    this.setupEventListeners();
  }

  /**
   * Event Listeners
   */
  setupEventListeners() {
    // Handle click on question cards
    this.$element.find(this.selectors.questionCards).on('click', (event) => {
      event.preventDefault();
      // console.log('Click Event Handling');
    });

    const tiltRight = (event) => {
      event.preventDefault();

      // Find the top card based on the question count
      const topCard = this.$element.find(this.selectors.cards)[
        this.$element.find(this.selectors.cards).length - this.questionCount
      ];

      // Check if the topCard exists and apply tilt-right class
      if (topCard) {
        topCard.classList.add('tilt-right');
      }
    };

    const tiltLeft = (event) => {
      event.preventDefault();

      // Find the top card based on the question count
      const topCard = this.$element.find(this.selectors.cards)[
        this.$element.find(this.selectors.cards).length - this.questionCount
      ];

      // Check if the topCard exists and apply tilt-right class
      if (topCard) {
        topCard.classList.add('tilt-left');
      }
    };

    this.$element.find('.questionCards__score--card a').on('click', (event) => {
      event.stopPropagation();
    });

    // Handle click on card no button
    this.$element.find(this.selectors.cardNoBtn).on('click', (event) => {
      event.preventDefault();
      // this.incrementQuestionCounter();
      const topCard = document.querySelector('.tilt-left');
      // const topCard = document.querySelector('.active-top-card');
      topCard.classList.add('swiped-left');
      topCard.classList.remove('tilt-left');
      this.scoreCalc(parseInt(topCard.getAttribute('data-id')), 'no');

      const secondCard = this.$element.find(this.selectors.cards)[
        this.$element.find(this.selectors.cards).length - this.questionCount
      ];
      if (secondCard) {
        secondCard.classList.add('tilt-left');
      }
    });

    // Handle click on card yes button
    this.$element.find(this.selectors.cardYesBtn).on('click', (event) => {
      event.preventDefault();
      // this.incrementQuestionCounter();
      const topCard = document.querySelector('.tilt-right');
      // const topCard = document.querySelector('.active-top-card');
      topCard.classList.add('swiped-right');
      topCard.classList.remove('tilt-right');
      this.scoreCalc(parseInt(topCard.getAttribute('data-id')), 'yes');

      const secondCard = this.$element.find(this.selectors.cards)[
        this.$element.find(this.selectors.cards).length - this.questionCount
      ];
      if (secondCard) {
        secondCard.classList.add('tilt-right');
      }
    });

    //tilt on mouse enter
    this.$element.find(this.selectors.cardYesBtn).on('mouseenter', tiltRight);

    this.$element.find(this.selectors.cardYesBtn).on('mouseleave', (event) => {
      event.preventDefault();
      const topCard = this.$element.find(this.selectors.cards)[
        this.$element.find(this.selectors.cards).length - this.questionCount
      ];
      if (topCard) {
        topCard.classList.remove('tilt-right');
      }
    });

    this.$element.find(this.selectors.cardNoBtn).on('mouseenter', tiltLeft);

    this.$element.find(this.selectors.cardNoBtn).on('mouseleave', (event) => {
      event.preventDefault();
      const topCard = this.$element.find(this.selectors.cards)[
        this.$element.find(this.selectors.cards).length - this.questionCount
      ];
      if (topCard) {
        topCard.classList.remove('tilt-left');
      }
    });

    //restart
    this.$element.find(this.selectors.restartButton).on('click', (event) => {
      event.preventDefault();

      const levelSection = document.querySelector('.questionCards__level');
      const swiperButtons = document.querySelector('.questionCards__navigation');
      const selectorContainer = document.querySelector('.selector__container');
      levelSection.classList.remove('hide');
      swiperButtons.classList.remove('hide');
      selectorContainer.classList.remove('hide');

      const cards = document.querySelectorAll('.questionCards__questions--card');
      cards.forEach((element, index) => {
        element.classList.remove('swiped-left', 'swiped-right'); // Remove multiple classes
        element.setAttribute('initial-level-action', '');
      });

      this.backup_questionCards.forEach((element) => {
        document.querySelector('.questionCards__questions').append(element);
      });

      this.questionCount = 0;
      this.incrementQuestionCounter();
      this.ans_yes_card = [];
      this.ans_no_card = [];
      this.score_point = 0;
      this.questionCounter.text(1);
    });
  }

  /**
   * Increment Question Counter
   */
  incrementQuestionCounter() {
    const levelSection = document.querySelector('.questionCards__level');
    const swiperButtons = document.querySelector('.questionCards__navigation');
    const selectorContainer = document.querySelector('.selector__container');

    this.questionCount++;

    // setting tilted card pattern

    const thirdCard = this.$element.find(this.selectors.cards)[
      this.$element.find(this.selectors.cards).length - this.questionCount - 2
    ];

    if (thirdCard) {
      thirdCard.style.transform = `rotate(-5deg)`;
      // thirdCard.style.background = '#3b1d52';
    }

    const secondCard = this.$element.find(this.selectors.cards)[
      this.$element.find(this.selectors.cards).length - this.questionCount - 1
    ];

    if (secondCard) {
      secondCard.style.transform = `rotate(5deg)`;
      secondCard.style.background = ``;
    }

    const topCard = this.$element.find(this.selectors.cards)[
      this.$element.find(this.selectors.cards).length - this.questionCount
    ];
    if (topCard) {
      topCard.style.transform = ``;
      topCard.style.background = ``;
      topCard.classList.add('active-top-card');
    }

    const prevTopCard = this.$element.find(this.selectors.cards)[
      this.$element.find(this.selectors.cards).length - this.questionCount + 1
    ];
    var prevTopCard_level = '';
    if (prevTopCard) {
      prevTopCard.classList.remove('active-top-card');
      prevTopCard_level = this.card_data[parseInt(prevTopCard.getAttribute('data-id'))].level_name;
    }

    if (this.questionCount > this.$element.find(this.selectors.cards).length) {
      levelSection.classList.add('hide');
      swiperButtons.classList.add('hide');
      selectorContainer.classList.add('hide');
      this.$element.find('#total-score').text(this.score_point);
      let pass_mark = this.$element.find('#total-score').attr('pass_mark');
      var score_info = '';
      if (this.score_point > pass_mark) {
        this.$element.find('#pass-result-item')[0].style.display = '';
        this.$element.find('#fail-result-item')[0].style.display = 'none';
        score_info = this.pass_result_info.replace("{score_point}", this.score_point);
      } else {
        this.$element.find('#pass-result-item')[0].style.display = 'none';
        this.$element.find('#fail-result-item')[0].style.display = '';
        score_info = this.fail_result_info.replace("{score_point}", this.score_point);
      }
      this.$element.find('#score-info').text(score_info);

    } else {
      levelSection.classList.remove('hide');
      swiperButtons.classList.remove('hide');
      selectorContainer.classList.remove('hide');
    }

    //
    const topCad = document.querySelector('.active-top-card');
    if (topCad) {
      var curent_card_info = this.card_data[parseInt(topCad.getAttribute('data-id'))];
      this.$element.find('.level').text(curent_card_info.level_name);
      this.$element.find('#level-total-counter').text(curent_card_info.level_total_question);
      this.questionCounter.text(curent_card_info.level_count_num);
    }
  }

  /**
   * score calculation
   * @param {*} data_id
   * @param {*} action
   */
  scoreCalc(data_id, action) {
    if (action == 'yes') {
      this.array_add_unique_items(this.ans_yes_card, data_id);
      this.score_point = this.score_point + this.card_data[data_id]['score'];
      this.card_data[data_id].initial_question_ids.forEach((element, index) => {
        this.score_point = this.score_point - element.score;
        this.score_point = this.score_point + element.score * element.multiplier;
      });
      this.card_data[data_id].next_question_ids.forEach((element) => {
        this.$element.find('.questionCards__questions--card[data-id="' + element + '"]').attr('initial-level-action', 1);
      });
    }
    if (action == 'no') {
      this.array_add_unique_items(this.ans_no_card, data_id);
      this.card_data[data_id].next_question_ids.forEach((element) => {
        // this.array_add_unique_items(this.ans_no_card, element);
        let inital_action = this.$element.find('.questionCards__questions--card[data-id="' + element + '"]').attr('initial-level-action');
        if (inital_action == '') {
          this.$element.find('.questionCards__questions--card[data-id="' + element + '"]').attr('initial-level-action', 0);
        }
      });
    }

    // check next if next card id is preent in ans_no_card variables
    if (this.ans_no_card.length > 0 && this.ans_no_card.includes(data_id)) {
      // check all no_cards next ids and add to no-cards
      var condition_no_card = true;
      while (condition_no_card) {
        var prev_length = this.ans_no_card.length;
        this.ans_no_card.forEach((no_id) => {
          this.card_data[no_id].next_question_ids.forEach((element) => {
            this.array_add_unique_items(this.ans_no_card, element);
            // this.$element.find('.questionCards__questions--card[data-id="' + element + '"]').remove();
            let inital_action = this.$element.find('.questionCards__questions--card[data-id="' + element + '"]').attr('initial-level-action');
            if (inital_action == '') {
              this.$element.find('.questionCards__questions--card[data-id="' + element + '"]').attr('initial-level-action', 0);
            }
          });
        });
        if (prev_length == this.ans_no_card.length) {
          condition_no_card = false;
        }
      }
    }

    // check if the inital action is 1 or 0.
    var condition_inital_card = true;
    while (condition_inital_card) {
      let next_topCard = this.$element.find(this.selectors.cards)[
        this.$element.find(this.selectors.cards).length - (this.questionCount + 1)
      ];
      if (next_topCard) {
        let next_initial_action = next_topCard.getAttribute('initial-level-action');
        let next_data_id = next_topCard.getAttribute('data-id');
        if (next_initial_action && next_initial_action == 0) {
          this.$element.find('.questionCards__questions--card[data-id="' + next_data_id + '"]').remove();
        } else {
          condition_inital_card = false;
        }
      } else {
        condition_inital_card = false;
      }
    }

    this.incrementQuestionCounter();
  }

  /** add unique data in array */
  array_add_unique_items(select_array, select_data) {
    if (!select_array.includes(select_data)) {
      select_array.push(select_data);
    }
  }
}

/**
 * =========================================================================
 * Register JS Handler for the Widget
 *
 * When Elementor frontend was initiated, and the widget is ready, register
 * the widget JS handler.
 * =========================================================================
 */

window.addEventListener('elementor/frontend/init', () => {
  const addHandler = ($element) => {
    elementorFrontend.elementsHandler.addHandler(QuestionHandler, {
      $element,
    });
  };

  elementorFrontend.hooks.addAction('frontend/element_ready/question-card.default', addHandler);
});
