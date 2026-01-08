<script type="text/javascript" src="{{ asset('js/Genealogy/OrgChart.js') }}"></script>

<script type="text/javascript">
    {!! $genealogy !!}
</script>

<script type="text/javascript">

    // Count total children recursively
    function childCount(id) {
        let count = 0;
        for (let i = 0; i < data.length; i++) {
            if (data[i].pid == id && data[i].name !== '') {
                count++;
                count += childCount(data[i].id);
            }
        }
        return count;
    }

    // Add child count value to nodes
    data.forEach(function (node) {
        node.field_number_children = childCount(node.id);
    });

    // Extend template to show children count circle
    OrgChart.templates.polina.field_number_children = `
        <circle cx="60" cy="110" r="15" fill="#F57C00"></circle>
        <text fill="black" x="60" y="115" text-anchor="middle">{val}</text>
    `;

    // SVG icon
    var webcallMeIcon = `
        <svg width="24" height="24" viewBox="0 0 300 400">
            <g transform="matrix(1,0,0,1,40,40)">
                <path fill="#5DB1FF" d="M260.423,0H77.431c-5.522,0-10,4.477-10,10v317.854c0,5.522,4.478,10,10,10h182.992c5.522,0,10-4.478,10-10V10C270.423,4.477,265.945,0,260.423,0z"/>
            </g>
        </svg>
    `;

    // Initialize OrgChart (ONLY ONCE)
    var chart = new OrgChart(document.getElementById("grptree"), {
        mouseScroolBehaviour: BALKANGraph.action.zoom,
        scaleInitial: 0.5,
        template: "polina",

        nodeBinding: {
            field_0: "name",
            field_1: "title",
            field_2: "downlinecount",
            img_0: "img",
            field_number_children: "field_number_children"
        },

        nodeMenu: {
            call: {
                text: "View",
                icon: webcallMeIcon,
                onClick: function (nodeId) {
                    callHandler(nodeId);
                }
            }
        },

        nodes: data
    });

    // Example handler
    function callHandler(nodeId) {
        console.log("Clicked Node ID:", nodeId);
    }

</script>
