    <script>
        function startTime() {
          var today = new Date();
          var h = today.getHours();
          var m = today.getMinutes();
          var s = today.getSeconds();
          m = checkTime(m);
          s = checkTime(s);
          document.getElementById('curr-time').innerHTML =
          h + ":" + m + ":" + s;
          var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
          if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
          return i;
        }
    </script>
    
    <script>
        //  var time = new Date().getTime();
        //  $(document.body).bind("mousemove keypress", function(e) {
        //      time = new Date().getTime();
        //  });
    
        //  function refresh() {
        //      if(new Date().getTime() - time >= 15000) 
        //          window.location.reload(true);
        //      else 
        //          setTimeout(refresh, 10000);
        //  }
    
        //  setTimeout(refresh, 10000);
    </script>

<!--Select2-->
    <script src="../select2/js/select2.full.min.js"></script>
    <script>
         $(function () {
         //Initialize Select2 Elements
         $(".select2").select2();
         
     })
    </script>
    
</body>
</html>
