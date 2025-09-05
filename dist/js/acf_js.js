jQuery(document).ready(function ($) {

  if (typeof acf !== "undefined") {

    acf.add_filter(
      "select2_ajax_data",
      acf_select2_ajax_data
    );
    var instance = new acf.Model({
      events: {
        'change select[id="acf-field_65e061a49c162"]': 'question_level_change',
      },
      question_level_change: function (e, $el) {
        $('div[data-key="field_65e061469c161"] .acf-table tbody tr:not(.acf-clone) .remove a[data-event="remove-row"]').trigger('click');
        $('.-confirm a[data-event="confirm"]').trigger('click');
      }
    });
  }

  // 
  function acf_select2_ajax_data(data, args, $input, field, instance) {
    // do something to data

    // For select_question 
    if (field[0]["dataset"]["name"] === "select_question") {
      var field = acf.findFields({
        name: "question_level",
        limit: 1,
      });
      var question_level_id = field.find($("select")).val();
      if (question_level_id) {
        data.question_level_id = question_level_id;
      }
    }

    // return
    return data;
  }

  // 
});
