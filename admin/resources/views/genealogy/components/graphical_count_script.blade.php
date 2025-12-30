 <!--begin::MLM CustomPage Scripts -->
 <script type="text/javascript" src="{{$_ENV['UI_ASSET_URL']}}/assets/custom/js/OrgChart.js"></script>
<script type="text/javascript">{!!$genealogy!!}</script>
<script type="text/javascript">
 for (var i = 0; i < data.length; i++) {
            data[i].field_number_children = data[i].downlinecount;
        }
        function childCount(id) {
            let count = 0;
            for (var i = 0; i < data.length; i++) {
                if (data[i].pid == id) {
                    if(data[i].name != '')
                    {
                        count++;
                        count += childCount(data[i].id);
                    }
                }
            }
            return count;
        }
        OrgChart.templates.{{$genealogyTemplate}}.field_number_children = '<circle cx="60" cy="110" r="15" fill="#F57C00"></circle><text fill="#fffff" x="60" y="115" text-anchor="middle">{val}</text>';
        var webcallMeIcon = '<svg width="24" height="24" viewBox="0 0 300 400"><g transform="matrix(1,0,0,1,40,40)"><path fill="#5DB1FF" d="M260.423,0H77.431c-5.522,0-10,4.477-10,10v317.854c0,5.522,4.478,10,10,10h182.992c5.522,0,10-4.478,10-10V10 C270.423,4.477,265.945,0,260.423,0z M178.927,302.594c0,5.522-4.478,10-10,10c-5.523,0-10-4.478-10-10v-3.364h20V302.594z M250.423,279.229H87.431V58.624h162.992V279.229z" /><path fill="#5DB1FF" d="M118.5,229.156c4.042,4.044,9.415,6.271,15.132,6.271c5.715,0,11.089-2.227,15.133-6.269l29.664-29.662 c4.09-4.093,6.162-9.442,6.24-14.816c5.601-0.078,10.857-2.283,14.829-6.253l29.66-29.662c4.042-4.043,6.269-9.417,6.269-15.133 c0-5.716-2.227-11.09-6.269-15.13l-9.806-9.806c-4.041-4.043-9.415-6.27-15.132-6.27c-5.716,0-11.09,2.227-15.132,6.269 l-29.663,29.662c-4.092,4.092-6.164,9.443-6.242,14.817c-5.601,0.078-10.857,2.283-14.828,6.252l-29.661,29.662 c-4.042,4.043-6.269,9.418-6.268,15.136c0,5.716,2.227,11.089,6.269,15.129L118.5,229.156z M168.618,147.548l29.662-29.661 c1.587-1.587,3.696-2.461,5.94-2.461c2.243,0,4.353,0.874,5.938,2.461l9.808,9.808c1.586,1.586,2.46,3.694,2.46,5.937 c0,2.244-0.874,4.354-2.462,5.941l-29.658,29.661c-1.588,1.587-3.697,2.46-5.941,2.46c-2.243,0-4.353-0.874-5.938-2.46 l-0.309-0.309l19.598-19.598c2.539-2.539,2.539-6.654,0-9.192c-2.537-2.538-6.654-2.538-9.191,0l-19.599,19.598l-0.308-0.308 C165.344,156.152,165.345,150.823,168.618,147.548z M117.888,198.28l29.66-29.661c1.587-1.586,3.695-2.46,5.939-2.46 c2.242,0,4.349,0.872,5.934,2.455c0.002,0.001,0.004,0.003,0.005,0.005l0.309,0.309l-19.598,19.598 c-2.539,2.538-2.539,6.653,0,9.191c1.269,1.27,2.933,1.904,4.596,1.904s3.327-0.635,4.596-1.904l19.599-19.598l0.309,0.309 c3.273,3.273,3.273,8.603,0,11.877l-29.662,29.66c-1.588,1.588-3.698,2.462-5.941,2.462c-2.243,0-4.352-0.874-5.938-2.462 l-9.807-9.806c-1.586-1.586-2.46-3.694-2.46-5.938C115.426,201.978,116.3,199.868,117.888,198.28z" /></g></svg>';
        //console.log(data);
        var chart = new OrgChart(document.getElementById("grptree"), {
        //showXScroll: BALKANGraph.scroll.visible, 
        //showYScroll: BALKANGraph.scroll.visible, 
        mouseScroolBehaviour: BALKANGraph.action.zoom,
        scaleInitial: 0.5,
        template: "{{$genealogyTemplate}}",
        nodeBinding: {
            field_0: "name",
            field_1: "title",
            img_0: "img",
            field_number_children: "field_number_children"
        },
        nodeMenu: {
            call: {
                text: "View",
                icon: webcallMeIcon,
                onClick: callHandler
            }
        },
        nodes: data
    });
    document.getElementById("selectTemplate").addEventListener("change", function () {
        chart.config.template = this.value;
        chart.draw();
    });
    function callHandler(nodeId) {
        var nodeData = chart.get(nodeId);
        console.log(nodeData);
        if( nodeData["name"]!='' ||  nodeData["pid"]=='0'){
            window.location.href= "{{$_ENV['BCPATH']}}/memberarea/show/"+nodeId;
        }else{
            window.open("{{$_ENV['FCPATH']}}/register/"+"{{$sub1}}/"+"{{$sub2}}/"+nodeData["pid"]+"/"+nodeData["position"],"_blank");
        }
    }
    function applyTemplate() {
        var genealogyTemplate = document.getElementById('selectTemplate').value;
        Swal.fire({
            title: "{{ __('Do you want to activate?') }}", 
            text: "{{ __('Genealogy selected') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ __('Yes, sure') }}",
            cancelButtonText: "{{ __('Cancel it') }}",
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            padding: '2.5rem',
            width: 400,
            heightAuto: false,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'bg-neutral-500 text-white hover:bg-neutral-600 font-semibold py-2 px-4 rounded-lg',
                cancelButton: 'bg-red-500 text-white hover:bg-red-600 font-semibold py-2 px-4 rounded-lg ms-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Using Fetch API for AJAX
                fetch("{{ $_ENV['BCPATH'] }}/countgenealogy/updatetemplate", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        'templateKey': '{{ $matrix_name }}',
                        'templateValue': genealogyTemplate
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            "{{ __('OK') }}",
                            "{{ __('Genealogy updated') }}",
                            'success'
                        );
                    } else {
                        Swal.fire(
                            "{{ __('Error') }}",
                            "{{ __('Something went wrong') }}",
                            'error'
                        );
                    }
                })
                .catch(error => {
                    Swal.fire(
                        "{{ __('Error') }}",
                        "{{ __('Error handling here') }}",
                        'error'
                    );
                });
            } else {
                Swal.fire(
                    "{{ __('Cancelled') }}",
                    "{{ __('Your records are safe') }}",
                    'error'
                );
            }
        });
        return false;
    }
    document.getElementById('default_matrix').addEventListener('change', function() {
        var matrix_id = this.value;
        if (matrix_id > 0) {
            // Show preloader

            // Use Fetch API to make the POST request
            fetch("{{$_ENV['BCPATH']}}/genealogy/getcryptdata", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json", // Set the content type for the request body
                },
                body: JSON.stringify({
                    matrix_id: matrix_id
                })
            })
            .then(response => response.text()) // Assuming the server response is JSON
            .then(data => {
                // Redirect the user with the data received from the server
                window.location.href = "{{$_ENV['BCPATH']}}/countgenealogy/viewtree/" + data;
            })
            .catch(error => {
                console.error("Error:", error);
                // Handle errors if necessary
                // document.getElementById('preloader').style.display = "none"; // Hide preloader on error
            });
        }
    });


</script>