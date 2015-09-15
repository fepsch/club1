<script>
    $(document).ready(function() {
        $(function() {
            $('.thumb-chef').click(function(event) {
                event.preventDefault();
                var url = $(this).attr('href');
                $.post(url).done(function(data){
                    $('#result').html(data);
                });
            });
        });
    });
</script>
<div>
    <?php $this->load->view('mipanel/menu') ?>
    <div id="content-panel">
        <?php $this->load->view('mipanel/carrusel_chefs') ?>
        <div id="result"></div>
    </div>
</div>
</body>
</html>
