<template>
<div class="feedback right">
  <div class="tooltips">
    <div class="btn-group dropup" :class="{ open: show }">
      <button type="button" class="btn btn-primary dropdown-toggle btn-circle btn-lg"  @click.prevent="show=!show">
        <i class="fa fa-bug fa-2x" title="Report Bug"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-right dropdown-menu-form">
        <div class="report">
          <h2 class="text-center">Report Bug</h2>
          <form class="doo" method="post" action="report.php">
            <div class="col-sm-12">
              <textarea required name="comment" class="form-control" placeholder="Please tell us what bug or issue you've found, provide as much detail as possible." v-model="message"></textarea>
              <input name="screenshot" type="hidden" class="screen-uri">
              <span class="screenshot pull-right">
              <i class="fa fa-camera cam" title="Take Screenshot"></i></span>
            </div>
            <div class="col-sm-12 clearfix">
              <button class="btn btn-primary btn-block" :disabled="canSubmit" @click.prevent="submit">Submit Report</button>
            </div>
          </form>
        </div>
        <div class="loading text-center hideme">
          <h2>Please wait...</h2>
          <h2><i class="fa fa-refresh fa-spin"></i></h2>
        </div>
        <div class="reported text-center hideme">
          <h2>Thank you!</h2>
          <p>Your submission has been received, we will review it shortly.</p>
          <div class="col-sm-12 clearfix">
            <button class="btn btn-success btn-block do-close">Close</button>
          </div>
        </div>
        <div class="failed text-center hideme">
          <h2>Oh no!</h2>
          <p>It looks like your submission was not sent.<br><br><a href="mailto:">Try contacting us by the old method.</a></p>
          <div class="col-sm-12 clearfix">
            <button class="btn btn-danger btn-block do-close">Close</button>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>
</div>
</template>

<script>
  export default {

  data() {  
    return {
      message: "",
      show: false
    }
  },
  computed: {
    canSubmit: function () {
      return ! this.message.length;
    }
  },
  methods: {
    submit(){
      axios.post(`/report-bug`, 
        {
          message: this.message,
          location: location.href
        },
        {
          headers: {
                  'Content-Type': 'multipart/form-data'
                }})
        .then(response => {
          this.show=false
          this.message = ""
          flash('A bug was successfull reported! Thank you!');
        })
        .catch(e => {
          this.show=false
          flash(e + "");
        })
    }
  }
};

//===========================================================

// (function ( $ ) {
//     $.fn.feedback = function(success, fail) {
//         self=$(this);
//         self.find('.dropdown-menu-form').on('click', function(e){e.stopPropagation()})

//         self.find('.screenshot').on('click', function(){
//             self.find('.cam').removeClass('fa-camera fa-check').addClass('fa-refresh fa-spin');
//             html2canvas($(document.body), {
//                 onrendered: function(canvas) {
//                     self.find('.screen-uri').val(canvas.toDataURL("image/png"));
//                     self.find('.cam').removeClass('fa-refresh fa-spin').addClass('fa-check');
//                 }
//             });
//         });

//===========================================================
</script>


<style scoped>
.btn-circle.btn-lg {
  width: 40px;
  height: 40px;
  padding: 5px 8px;
  font-size: 12px;
  line-height: 1.33;
  border-radius: 25px;
  z-index: 9999997;
}

.feedback{position: fixed; z-index: 99998;}
.feedback textarea{height: 180px; }
.feedback .screenshot{ position: relative; top: -24px; right: 10px; opacity: .6}
.feedback .screenshot:hover{  opacity: 1}
.feedback .reported p, .feedback .failed p  { height: 190px}
.feedback.left{left:5px; bottom:15px}
.feedback.right{right:5px; bottom:15px}
.feedback .dropdown-menu{width: 290px;height: 320px;bottom: 50px;}
.feedback.left .dropdown-menu{ left: 0px}
.feedback.right .dropdown-menu{ right: 0px}
.feedback .hideme{ display: none}

</style>