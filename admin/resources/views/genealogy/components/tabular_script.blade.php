
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- JSTree JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
    <!-- end::Footer -->
    <!--begin::MLM CustomPage Scripts -->
<script type="text/javascript">
var Treeview = {
    init: function () {
        var matrixId  = "{{ $matrixId }}";
var memberId  = "{{ $memberId ?? '' }}";
      $("#m_tree_6").jstree({
    core: {
        themes: { responsive: false },
        check_callback: true,
        data: {
            url: function (node) {
                return `/admin/genealogy/viewtree/gettabularview/${matrixId}/${memberId}`;
            },
            data: function (node) {
                return {
                    parent: node.id
                };
            }
        }
    },
    types: {
        default: { icon: "fa fa-folder m--font-brand" },
        file: { icon: "fa fa-file m--font-brand" }
    },
    state: { key: "demo3" },
    plugins: ["dnd", "state", "types"]
});
    }
};
jQuery(document).ready(function () {
    Treeview.init();
});
</script>
