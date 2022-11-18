<script type="text/javascript">

    $(document).ready(function () {

        $('#search_post_form').on('submit', function (e) {
            e.preventDefault();
            var search = $('#search').val();

            if (search.length !== 0) {
                this.submit();
            }

        });

    });

</script>
