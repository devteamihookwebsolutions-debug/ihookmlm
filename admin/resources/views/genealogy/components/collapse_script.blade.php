<div class="gendata"></div>

<script src="https://d3js.org/d3.v7.min.js"></script>

<script type="text/javascript">
  var treeData = {!! json_encode($genealogy) !!};
</script>

<script type="text/javascript">
  var margin = { top: 0, right: 30, bottom: 50, left: 60 },
      width = 30000 - margin.left - margin.right,
      height = 1000 - margin.top - margin.bottom;

  var svg = d3.select(".gendata").append("svg")
      .attr("width", width + margin.left + margin.right)
      .attr("height", height + margin.top + margin.bottom)
    .append("g")
      .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

  var i = 0, duration = 750, root;

  var treemap = d3.tree().size([height, width]);

  root = d3.hierarchy(treeData, d => d.children);
  root.x0 = height / 2;
  root.y0 = 0;

  root.children && root.children.forEach(collapse);
  update(root);

  function collapse(d) {
    if(d.children) {
      d._children = d.children;
      d._children.forEach(collapse);
      d.children = null;
    }
  }

  function update(source) {
    var treeData = treemap(root);
    var nodes = treeData.descendants(),
        links = treeData.descendants().slice(1);

    nodes.forEach(d => d.y = d.depth * 180);

    // Nodes
    var node = svg.selectAll('g.node')
      .data(nodes, d => d.id || (d.id = ++i));

    var nodeEnter = node.enter().append('g')
      .attr('class', 'node')
      .attr("transform", d => `translate(${source.y0},${source.x0})`)
      .on('click', click);

    // Circle style exactly as your design
    nodeEnter.append('circle')
      .attr('class', 'node fill-neutral-200 stroke-blue-600 stroke-[1.5]')
      .attr('r', 1e-6)
      .style("fill", d => d._children ? "lightsteelblue" : "#fff")
      .attr('cursor', 'pointer');

    // Text labels
    nodeEnter.append('text')
      .attr("dy", ".35em")
      .attr('class', 'text-xs fill-neutral-900')
      .attr("x", d => d.children || d._children ? -13 : 13)
      .attr("text-anchor", d => d.children || d._children ? "end" : "start")
      .text(d => d.data.name);

    // UPDATE
    var nodeUpdate = nodeEnter.merge(node);

    nodeUpdate.transition()
      .duration(duration)
      .attr("transform", d => `translate(${d.y},${d.x})`);

    nodeUpdate.select('circle.node')
      .attr('r', 10)
      .style("fill", d => d._children ? "lightsteelblue" : "#fff");

    // Exit
    var nodeExit = node.exit().transition()
      .duration(duration)
      .attr("transform", d => `translate(${source.y},${source.x})`)
      .remove();

    nodeExit.select('circle').attr('r', 1e-6);
    nodeExit.select('text').style('fill-opacity', 1e-6);

    // Links
    var link = svg.selectAll('path.link')
      .data(links, d => d.id);

    var linkEnter = link.enter().insert('path', "g")
      .attr("class", "link fill-none stroke-neutral-800 stroke-[1.5]")
      .attr('d', d => {
        var o = {x: source.x0, y: source.y0};
        return diagonal(o, o);
      });

    var linkUpdate = linkEnter.merge(link);
    linkUpdate.transition()
      .duration(duration)
      .attr('d', d => diagonal(d, d.parent));

    var linkExit = link.exit().transition()
      .duration(duration)
      .attr('d', d => {
        var o = {x: source.x, y: source.y};
        return diagonal(o, o);
      }).remove();

    nodes.forEach(d => { d.x0 = d.x; d.y0 = d.y; });

    // Curved path
    function diagonal(s, d) {
      return `M ${s.y} ${s.x}
              C ${(s.y + d.y) / 2} ${s.x},
                ${(s.y + d.y) / 2} ${d.x},
                ${d.y} ${d.x}`;
    }

    // Click to toggle children
    function click(event, d) {
      if(d.children) {
        d._children = d.children;
        d.children = null;
      } else {
        d.children = d._children;
        d._children = null;
      }
      update(d);
    }
  }
</script>
