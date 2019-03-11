<footer class="footer fixed-bottom bg-light" style="height: 4vh">
      <div class="container">
      <small class="text-muted mt-5">Copyright &copy; 2019 | <a class="text-dark" target="_blank" href="https://yashwantlodhi.com/">Yashwant Lodhi</a></small>
      </div>
    </footer>
</section>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script>
        $('#diary-text').bind('input propertychange', function(){
            $.ajax({
                method: "POST",
                url: "autoupdate.php",
                data:{ content: $("#diary-text").val() }
            });
        });

        $(function() {
            var data = $('textarea').val();
            $('textarea').focus().val('').val(data);
        });

        $(document).ready(function(){
            var $textarea = $('#diary-text');
            $textarea.scrollTop($textarea[0].scrollHeight);
        });
    
    </script>
    
  </body>
</html>