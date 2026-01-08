<script type="text/javascript" src="{{ asset('js/Genealogy/OrgChart.js') }}"></script>

<script type="text/javascript">
    {!! $genealogy !!}
</script>

<script type="text/javascript">
    // Your OrgChart code here...
    var chart = new OrgChart(document.getElementById("grptree"), {
        mouseScroolBehaviour: BALKANGraph.action.zoom,
        scaleInitial: 0.5,
        template: "polina",
        nodeBinding: {
            field_0: "name",
            field_1: "title",
           field_2: "downlinecount",
            img_0: "img"
        },
        nodes: data
    });
</script>
