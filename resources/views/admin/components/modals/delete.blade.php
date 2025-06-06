<div class="crud-item-delete d-none">

    <form id="deleteCrudItemForm" class="form" method="POST">
        @method('DELETE')
        @csrf
        <input type="submit" value="Delete" class="btn btn-danger">
    </form>

</div>



<script type="text/javascript">
    function deleteCrudItem(route, key='Item') {
        var form = document.getElementById('deleteCrudItemForm');
        var attribute = document.createAttribute("action");
        attribute.value = route;
        form.setAttributeNode(attribute);

        Swal.fire({
            text: "Once you delete this, can't be restore.",
            icon: "error",
            title: "Do you want to delete this "+key+"?",
            // showDenyButton: true,
            confirmButtonText: "Yes, Delete "+key,
            confirmButtonColor: "#d33",
            showCancelButton: true,
            reverseButtons:true
            // denyButtonText: `Don't save`
        }).then((result) => {

        /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                form.submit();
                
            } else if (result.isDenied) {

                
            }

        });
    }

    function Export(format) {
        var url = window.location.pathname + '?export=' + format;
        window.location.replace(url);
    }
</script>