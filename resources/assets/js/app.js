
if (!window.location.origin) {
        window.location.origin = window.location.protocol +
        '//' + window.location.hostname +
        (window.location.port ? (':' + window.location.port) : '');
}

window._ = require('lodash');

require('bootstrap-sass');
require('./AdminLTE');
require('./datatables.js')

import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

function working_days(from, to, cb) {
  function get_bank_holidays(cb) {
    $.getJSON('https://www.gov.uk/bank-holidays.json', null, function(data) {
      banner.addClass("alt");
      //console.log(data);
      var event_lst = data['england-and-wales'].events;
      var holidays = [];
      for (var d in event_lst) {
        var bhd = event_lst[d].date.split('-');
        var dt = new Date(bhd[0], bhd[1]-1, bhd[2]);
        holidays.push(dt.getTime());
        //console.log(bhd);
      }
      //console.log(holidays);
      if (cb)
        cb(holidays);
    });
  }

  function getNumWorkDays(startDate, endDate, bhd) {
      var numWorkDays = 0;
      var currentDate = new Date(startDate);
      while (currentDate <= endDate) {
          // Skips Sunday and Saturday
          if (currentDate.getDay() !== 0 && currentDate.getDay() !== 6 && (! bhd.includes(currentDate.getTime()))) {
              numWorkDays++;
              //console.log(currentDate);
              //console.log(currentDate in bhd);
          }
          currentDate.setDate(currentDate.getDate() + 1);
          //currentDate = currentDate.addDays(1);
      }
      return numWorkDays;
  }

  get_bank_holidays(function (bhd) {
    var wd = getNumWorkDays(from, to, bhd);
    console.log(wd);
    if (cb)
      cb(wd);
  });
}

function propose_duration(selector) {
  var from = $('#from').val();
  var to = $('#to').val();
  console.log(from);
  working_days(from, to, function (wd) {
    $(selector).val(wd);
  });
}


$(function() {

    if(localStorage.expandedMenu==0) { $("body").addClass('sidebar-collapse'); }
    $('body').bind('expanded.pushMenu', function() { localStorage.expandedMenu = 1; });
    $('body').bind('collapsed.pushMenu', function() { localStorage.expandedMenu = 0; });

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    $("#uploader").dropzone({
        dictDefaultMessage: "Drag & drop file or <strong><u>browse</u></strong>",
        maxFilesize: 20, // MB
        addRemoveLinks: false,
        createImageThumbnails:false,
        init: function () {
            this.on('success', function(file, message) {
                window.location.reload(true);
            });
        },
        uploadprogress: function(file, progress, bytesSent) {
           $('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
        },

        error: function(file, response) {
            $('.progress-bar').css('width', 0+'%').attr('aria-valuenow', 0);
            alert('Opps! That did not work. Please check the upload specification and try again');
        }
    });

    $('div.alert').not('.alert-important').delay(6000).fadeOut(350);


    $('#datepicker').datepicker({ changeMonth: true, changeYear: true, inline: true,
        dateFormat: "yy-mm-dd", altField: "#d", altFormat: "yy-mm-dd" });
    $('#enrolment_date').change(function(){ $('#datepicker').datepicker('setDate', $(this).val()); });
    $('#datepicker').change(function(){ $('#enrolment_date').attr('value',$(this).val()); });
    $('#datepicker').datepicker('setDate', $('#enrolment_date').val());


    $('#from_datepicker').datepicker({ changeMonth: true, changeYear: true, inline: true,
        dateFormat: "yy-mm-dd", altField: "#d", altFormat: "yy-mm-dd" });
    $('#from').change(function(){ $('#from_datepicker').datepicker('setDate', $(this).val()); });
    $('#from_datepicker').change(function(){ $('#from').attr('value',$(this).val()); propose_duration('#duration')});
    $('#from_datepicker').datepicker('setDate', $('#from').val());


    $('#to_datepicker').datepicker({ changeMonth: true, changeYear: true, inline: true,
        dateFormat: "yy-mm-dd", altField: "#d", altFormat: "yy-mm-dd" });
    $('#to').change(function(){ $('#to_datepicker').datepicker('setDate', $(this).val()); });
    $('#to_datepicker').change(function(){ $('#to').attr('value',$(this).val()); });
    $('#to_datepicker').datepicker('setDate', $('#to').val());


    $('#due_datepicker').datepicker({ changeMonth: true, changeYear: true, inline: true,
        dateFormat: "yy-mm-dd", altField: "#d", altFormat: "yy-mm-dd" });
    $('#due').change(function(){ $('#due_datepicker').datepicker('setDate', $(this).val()); });
    $('#due_datepicker').change(function(){ $('#due').attr('value',$(this).val()); });
    $('#due_datepicker').datepicker('setDate', $('#due').val());


    (function($) {
        var escape_html = function(str) {
            return str;
            return str.replace(/</gm, "&lt;").replace(/>/gm, "&gt;")
        };
        var unescape_html = function(str) {
            return str;
            return str.replace(/&lt;/gm, "<").replace(/&gt;/gm, ">")
        };
        $.fn.editable = function(event, callback) {

            if (typeof callback !== "function") callback = function() {};
            
            if (typeof event === "string") {
                var trigger = this;
                var action = event;
                var type = "input"

            } else if (typeof event === "object") {

                var trigger = event.trigger || this;
                if (typeof trigger === "string"){
                    trigger = $(trigger);
                }
                var action = event.action || "click";
                var type = event.type || "input"
            } else {
                throw 'Argument Error - $.editable("click", function(){ ~~ })'
            }
            var target = this;
            var edit = {};
            edit.start = function(e) {
                trigger.unbind(action === "clickhold" ? "mousedown" : action);
                if (trigger !== target) trigger.hide();
                var old_value = target.text().trim();
                var input = $("<textarea>");
                input.val(old_value).css(
                    "width", type === "textarea" ? 
                    "100%" : 
                    target.width() + target.height())
                        .css("font-size", "100%")
                        .css("margin", 0)
                        .attr("id", "editable_" + new Date * 1)
                        .addClass("editable");
                input.css("height", target.height());

                var finish = function() {
                    let result = input.val().trim()
                    target.html(result);
                    callback({
                        value: result,
                        target: target,
                        old_value: old_value
                    });
                    edit.register();
                    if (trigger !== target) trigger.show()
                };
                input.blur(finish);
                target.html(input);
                input.focus()
            };
            edit.register = function() {
                if (action === "clickhold") {
                    var tid = null;
                    trigger.bind("mousedown", function(e) {
                        tid = setTimeout(function() {
                            edit.start(e)
                        }, 500)
                    });
                    trigger.bind("mouseup mouseout", function(e) {
                        clearTimeout(tid)
                    })
                } else {
                    trigger.bind(action, edit.start)
                }
            };
            edit.register();
            return this
        }
    })($);

    $("#note").editable({type : "textarea", action : "click"}, function(e){
    $.ajax({
      url: window.location.origin + window.location.pathname + "/note",
      method: "POST",
      data: {
        content: e.value
      }
    })
    .fail(function(xhr) {
      alert("Opps! It looks like that note did not save.\nIf this keeps happening, please contact your site adminstrator");
    });
    });

    $('#datepicker').datepicker({ changeMonth: true, changeYear: true, inline: true,
        dateFormat: "yy-mm-dd", altField: "#d", altFormat: "yy-mm-dd" });
    $('#enrolment_date').change(function(){ $('#datepicker').datepicker('setDate', $(this).val()); });
    $('#datepicker').change(function(){ $('#enrolment_date').attr('value',$(this).val()); });
    $('#datepicker').datepicker('setDate', $('#enrolment_date').val());


window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#3c8dbc"
    },
    "button": {
      "background": "#3c8dbc",
      border: "solid 2px"
    }
  },
  "theme": "classic",
  "position": "bottom-right",
  "content": {
    "message": "This University of Lincoln service uses cookies to ensure you get the best experience."
  }
})});


});
