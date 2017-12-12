
window._ = require('lodash');

// window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');
require('./AdminLTE');
require('./datatables.js')

import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

$(function() {

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


    (function($){var escape_html=function(str){return str.replace(/</gm,"&lt;").replace(/>/gm,"&gt;")};var unescape_html=function(str){return str.replace(/&lt;/gm,"<").replace(/&gt;/gm,">")};$.fn.editable=function(event,callback){if(typeof callback!=="function")callback=function(){};if(typeof event==="string"){var trigger=this;var action=event;var type="input"}else if(typeof event==="object"){var trigger=event.trigger||this;if(typeof trigger==="string")trigger=$(trigger);var action=event.action||"click";var type=event.type||"input"}else{throw'Argument Error - $.editable("click", function(){ ~~ })'}var target=this;var edit={};edit.start=function(e){trigger.unbind(action==="clickhold"?"mousedown":action);if(trigger!==target)trigger.hide();var old_value=(type==="textarea"?target.text().replace(/<br( \/)?>/gm,"\n").replace(/&gt;/gm,">").replace(/&lt;/gm,"<"):target.text()).replace(/^\s+/,"").replace(/\s+$/,"");var input=type==="textarea"?$("<textarea>"):$("<input>");input.val(old_value).css("width",type==="textarea"?"100%":target.width()+target.height()).css("font-size","100%").css("margin",0).attr("id","editable_"+new Date*1).addClass("editable");if(type==="textarea")input.css("height",target.height());var finish=function(){var result=input.val().replace(/^\s+/,"").replace(/\s+$/,"");var html=escape_html(result);if(type==="textarea")html=html.replace(/[\r\n]/gm,"<br />");target.html(html);callback({value:result,target:target,old_value:old_value});edit.register();if(trigger!==target)trigger.show()};input.blur(finish);if(type==="input"){input.keydown(function(e){if(e.keyCode===13)finish()})}target.html(input);input.focus()};edit.register=function(){if(action==="clickhold"){var tid=null;trigger.bind("mousedown",function(e){tid=setTimeout(function(){edit.start(e)},500)});trigger.bind("mouseup mouseout",function(e){clearTimeout(tid)})}else{trigger.bind(action,edit.start)}};edit.register();return this}})($);

    var liveedit = {type : "textarea", action : "click"};
    $("#note").editable(liveedit, function(e){
    $.ajax({
      url: window.location.href + "/note",
      method: "POST",
      data: {
        content: e.value
      }
    })
    .done(function(data) {
      console.log('success', data)
    })
    .fail(function(xhr) {
      alert("Opps! It looks like that note did not save.\nIf this keeps happening, please contact your site adminstrator");
    });
    });
});
