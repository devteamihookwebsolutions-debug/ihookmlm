<script type="text/javascript" src="{{$_ENV['UI_ASSET_URL']}}/assets/custom/js/jquery-3.4.0.min.js"></script>
<script type="text/javascript" src="{{$_ENV['UI_ASSET_URL']}}/assets/custom/js/genealogy/jquery-ui.min.js"></script>
<!-- jQuery UI Layout -->
<script type="text/javascript" src="{{$_ENV['UI_ASSET_URL']}}/assets/custom/js/genealogy/jquery.layout-latest.min.js"></script>
<script type="text/javascript" src="{{$_ENV['UI_ASSET_URL']}}/assets/custom/js/primitives.latest.js?3600"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
                        jQuery('body').layout(
                        {
                            center__paneSelector: "#contentpanel"
                            , north__paneSelector: "#northpanel"
                            , north__resizable: false
                            , north__closable: false
                            , north__spacing_open: 0
                            , north__size: 40
                        });
                    });
</script>
<script type="text/javascript">
    var orgDiagram=null,treeItems={};function Setup(e){orgDiagram=e.orgDiagram(GetOrgDiagramConfig()),ShowGraphicsType(e.orgDiagram("option","actualGraphicsType"))}function LoadData(e){var i,n;for(i=0,n=data.length;i<n;i+=1)treeItems[data[i].id]=data[i];e.orgDiagram("option",{items:data,cursorItem:0}),e.orgDiagram("update")}function Update(e,i){e.orgDiagram("option",GetOrgDiagramConfig()),e.orgDiagram("update",i),ShowGraphicsType(e.orgDiagram("option","actualGraphicsType"))}function GetOrgDiagramConfig(){var e=parseInt(jQuery("input:radio[name=graphicsType]:checked").val(),10),i=Number(jQuery("#cssScale option:selected").val()),n=parseInt(jQuery("input:radio[name=pageFitMode]:checked").val(),10),t=parseInt(jQuery("input:radio[name=navigationMode]:checked").val(),10),a=parseInt(jQuery("input:radio[name=orientationType]:checked").val(),10),r=parseInt(jQuery("input:radio[name=minimalVisibility]:checked").val(),10),o=(parseInt(jQuery("input:radio[name=selectionPathMode]:checked").val(),10),parseInt(jQuery("input:radio[name=leavesPlacementType]:checked").val(),10)),p=(parseInt(jQuery("input:radio[name=hasSelectorCheckbox]:checked").val(),10),parseInt(jQuery("input:radio[name=hasButtons]:checked").val(),10),parseInt(jQuery("input:radio[name=verticalAlignment]:checked").val(),10)),l=parseInt(jQuery("input:radio[name=horizontalAlignment]:checked").val(),10),m=parseInt(jQuery("input:radio[name=connectorType]:checked").val(),10),c=parseInt(jQuery("input:radio[name=elbowType]:checked").val(),10),u=parseInt(jQuery("input:radio[name=showLabels]:checked").val(),10),d=parseInt(jQuery("input:radio[name=labelOrientation]:checked").val(),10),s=parseInt(jQuery("input:radio[name=labelPlacement]:checked").val(),10),y=jQuery("#color option:selected").val(),v=parseInt(jQuery("#lineWidth option:selected").val(),10),h=parseInt(jQuery("input:radio[name=lineType]:checked").val(),10),j=parseInt(jQuery("input:radio[name=arrowsDirection]:checked").val(),10),Q=parseInt(jQuery("#normalLevelShift option:selected").val(),10),b=parseInt(jQuery("#dotLevelShift option:selected").val(),10),g=parseInt(jQuery("#lineLevelShift option:selected").val(),10),f=parseInt(jQuery("#normalItemsInterval option:selected").val(),10),I=parseInt(jQuery("#dotItemsInterval option:selected").val(),10),T=parseInt(jQuery("#lineItemsInterval option:selected").val(),10),U=parseInt(jQuery("#cousinsIntervalMultiplier option:selected").val(),10),C=[];return C.push(new primitives.orgdiagram.ButtonConfig("delete","ui-icon-close","Delete")),C.push(new primitives.orgdiagram.ButtonConfig("properties","ui-icon-gear","Info")),C.push(new primitives.orgdiagram.ButtonConfig("add","ui-icon-person","Add")),{graphicsType:e,pageFitMode:n,navigationMode:t,scale:i,orientationType:a,verticalAlignment:p,horizontalAlignment:l,arrowsDirection:j,connectorType:m,elbowType:c,minimalVisibility:r,hasSelectorCheckbox:!1,leavesPlacementType:o,onCursorChanging:!1,onCursorChanged:!1,templates:[getContactTemplate(),getContactTemplate1(),getContactTemplate2(),getDefaultTemplate()],onItemRender:onTemplateRender,itemTitleFirstFontColor:primitives.common.Colors.White,itemTitleSecondFontColor:primitives.common.Colors.White,showLabels:u,labelOrientation:d,labelPlacement:s,labelOffset:2,linesType:h,linesColor:y,linesWidth:v,defaultTemplateName:"defaultTemplate",normalLevelShift:Q,dotLevelShift:b,lineLevelShift:g,normalItemsInterval:f,dotItemsInterval:I,lineItemsInterval:T,cousinsIntervalMultiplier:U}}function getDefaultTemplate(){var e=new primitives.orgdiagram.TemplateConfig;e.name="defaultTemplate";var i=parseInt(jQuery("#minimizedItemSize option:selected").val(),10);e.minimizedItemSize=new primitives.common.Size(i,i);var n=parseInt(jQuery("#highlightPadding option:selected").val(),10);e.highlightPadding=new primitives.common.Thickness(n,n,n,n),e.minimizedItemShapeType=parseInt(jQuery("input:radio[name=minimizedItemShapeType]:checked").val(),10),e.minimizedItemLineWidth=parseInt(jQuery("#minimizedItemLineWidth option:selected").val(),10),e.minimizedItemLineType=parseInt(jQuery("input:radio[name=minimizedItemLineType]:checked").val(),10),e.minimizedItemBorderColor=jQuery("#minimizedItemBorderColor option:selected").val(),e.minimizedItemFillColor=jQuery("#minimizedItemFillColor option:selected").val(),e.minimizedItemOpacity=parseFloat(jQuery("#minimizedItemOpacity option:selected").val());var t=parseInt(jQuery("#minimizedItemCornerRadius option:selected").val(),10);return e.minimizedItemCornerRadius=-1==t?null:t,e}function onSelectionChanged(e,i){for(var n=jQuery("#centerpanel").orgDiagram("option","selectedItems"),t="",a=0;a<n.length;a+=1){""!=t&&(t+=", "),t+="<b>'"+treeItems[n[a]].title+"'</b>"}t+=null!=i.parentItem?" Parent item <b>'"+i.parentItem.title+"'":"",jQuery("#southpanel").empty().append("User selected following items: "+t)}function onHighlightChanging(e,i){var n=null!=i.context?"User is hovering mouse over item <b>'"+i.context.title+"'</b>.":"";n+=null!=i.parentItem?" Parent item <b>'"+i.parentItem.title+"'":"",jQuery("#southpanel").empty().append(n)}function onHighlightChanged(e,i){var n=null!=i.context?"User hovers mouse over item <b>'"+i.context.title+"'</b>.":"";n+=null!=i.parentItem?" Parent item <b>'"+i.parentItem.title+"'":"",jQuery("#southpanel").empty().append(n)}function onCursorChanging(e,i){var n="User is clicking on item '"+i.context.title+"'.";n+=null!=i.parentItem?" Parent item <b>'"+i.parentItem.title+"'":"",jQuery("#southpanel").empty().append(n),i.oldContext.templateName=null,i.context.templateName="contactTemplate"}function onCursorChanged(e,i){var n="User clicked on item '"+i.context.title+"'.";n+=null!=i.parentItem?" Parent item <b>'"+i.parentItem.title+"'":"",jQuery("#southpanel").empty().append(n)}function onButtonClick(e,i){var n="User clicked <b>'"+i.name+"'</b> button for item <b>'"+i.context.title+"'</b>.";n+=null!=i.parentItem?" Parent item <b>'"+i.parentItem.title+"'":"",jQuery("#southpanel").empty().append(n)}function onMouseClick(e,i){var n="User clicked item <b>'"+i.context.title+"'</b>.";n+=null!=i.parentItem?" Parent item <b>'"+i.parentItem.title+"'":"",jQuery("#southpanel").empty().append(n)}function onMouseDblClick(e,i){var n="User double clicked item <b>'"+i.context.title+"'</b>.";n+=null!=i.parentItem?" Parent item <b>'"+i.parentItem.title+"'":"",jQuery("#southpanel").empty().append(n)}function ShowGraphicsType(e){var i=null;switch(e){case primitives.common.GraphicsType.SVG:i="SVG";break;case primitives.common.GraphicsType.Canvas:i="Canvas";break;case primitives.common.GraphicsType.VML:i="VML"}jQuery("#actualGraphicsType").empty().append("Graphics Type: "+i)}jQuery(document).ready(function(){jQuery.ajaxSetup({cache:!1}),jQuery("#contentpanel").layout({center__paneSelector:"#centerpanel",south__paneSelector:"#southpanel",south__resizable:!1,south__closable:!1,south__spacing_open:0,south__size:50,center__onresize:function(){null!=orgDiagram&&jQuery("#centerpanel").orgDiagram("update",primitives.common.UpdateMode.Refresh)}});var e=jQuery("#pageFitMode");for(var i in{None:0,PageWidth:1,PageHeight:2,FitToPage:3}){var n=primitives.common.PageFitMode[i];e.append(jQuery("<br/><label><input aria-label='label' name='pageFitMode' type='radio' value='"+n+"' "+(n==primitives.common.PageFitMode.FitToPage?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=pageFitMode]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var t=jQuery("#navigationMode");for(var i in primitives.common.NavigationMode){n=primitives.common.NavigationMode[i];t.append(jQuery("<br/><label><input aria-label='label' name='navigationMode' type='radio' value='"+n+"' "+(n==primitives.common.NavigationMode.Default?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=navigationMode]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var a=jQuery("#orientationType");for(var i in primitives.common.OrientationType){n=primitives.common.OrientationType[i];a.append(jQuery("<br/><label><input aria-label='label' name='orientationType' type='radio' value='"+n+"' "+(n==primitives.common.OrientationType.Top?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=orientationType]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var r=jQuery("#verticalAlignment");for(var i in primitives.common.VerticalAlignmentType){n=primitives.common.VerticalAlignmentType[i];r.append(jQuery("<br/><label><input aria-label='label' name='verticalAlignment' type='radio' value='"+n+"' "+(n==primitives.common.VerticalAlignmentType.Middle?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=verticalAlignment]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var o=jQuery("#horizontalAlignment");for(var i in primitives.common.HorizontalAlignmentType){n=primitives.common.HorizontalAlignmentType[i];o.append(jQuery("<br/><label><input aria-label='label' name='horizontalAlignment' type='radio' value='"+n+"' "+(n==primitives.common.HorizontalAlignmentType.Center?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=horizontalAlignment]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});e=jQuery("#minimalVisibility");for(var i in primitives.common.Visibility){n=primitives.common.Visibility[i];e.append(jQuery("<br/><label><input aria-label='label' name='minimalVisibility' type='radio' value='"+n+"' "+(n==primitives.common.Visibility.Dot?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=minimalVisibility]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var p=jQuery("#selectionPathMode");for(var i in primitives.common.SelectionPathMode){n=primitives.common.SelectionPathMode[i];p.append(jQuery("<br/><label><input aria-label='label' name='selectionPathMode' type='radio' value='"+n+"' "+(n==primitives.common.SelectionPathMode.FullStack?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=selectionPathMode]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var l=jQuery("#leavesPlacementType");for(var i in primitives.common.ChildrenPlacementType){n=primitives.common.ChildrenPlacementType[i];l.append(jQuery("<br/><label><input aria-label='label' name='leavesPlacementType' type='radio' value='"+n+"' "+(n==primitives.common.ChildrenPlacementType.Horizontal?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=leavesPlacementType]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var m=jQuery("#hasSelectorCheckbox");for(var i in primitives.common.Enabled){n=primitives.common.Enabled[i];m.append(jQuery("<br/><label><input aria-label='label' name='hasSelectorCheckbox' type='radio' value='"+n+"' "+(n==primitives.common.Enabled.True?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=hasSelectorCheckbox]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var c=jQuery("#hasButtons");for(var i in primitives.common.Enabled){n=primitives.common.Enabled[i];c.append(jQuery("<br/><label><input aria-label='label' name='hasButtons' type='radio' value='"+n+"' "+(n==primitives.common.Enabled.Auto?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=hasButtons]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var u=jQuery("#arrowsDirection");for(var i in primitives.common.GroupByType){n=primitives.common.GroupByType[i];u.append(jQuery("<br/><label><input aria-label='label' name='arrowsDirection' type='radio' value='"+n+"' "+(n==primitives.common.GroupByType.None?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=arrowsDirection]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var d=jQuery("#connectorType");for(var i in primitives.common.ConnectorType){n=primitives.common.ConnectorType[i];d.append(jQuery("<br/><label><input aria-label='label' name='connectorType' type='radio' value='"+n+"' "+(n==primitives.common.ConnectorType.Squared?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=connectorType]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var s=jQuery("#elbowType");for(var i in primitives.common.ElbowType){n=primitives.common.ElbowType[i];s.append(jQuery("<br/><label><input aria-label='label' name='elbowType' type='radio' value='"+n+"' "+(n==primitives.common.ElbowType.None?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=elbowType]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var y=jQuery("#lineType");for(var i in primitives.common.LineType){n=primitives.common.LineType[i];y.append(jQuery("<br/><label><input aria-label='label' name='lineType' type='radio' value='"+n+"' "+(n==primitives.common.LineType.Solid?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=lineType]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var v=jQuery("<select></select>");for(var i in jQuery("#color").append(v),primitives.common.Colors){n=primitives.common.Colors[i];v.append(jQuery("<option value='"+n+"' "+(n==primitives.common.Colors.Silver?"selected":"")+" >"+i+"</option>"))}jQuery("#color").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var h=["NULL",0,1,2,3,4,5,6,7,8,9,10],j=jQuery("<select></select>");jQuery("#minimizedItemCornerRadius").append(j);for(var Q=0;Q<h.length;Q+=1){n=h[Q];j.append(jQuery("<option value='"+("NULL"==n?-1:n)+"' "+("NULL"==n?"selected":"")+" >"+n+"</option>"))}jQuery("#minimizedItemCornerRadius").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var b=[1,2,3,4,5,6,7,8,9,10,12,14,16,18,20,30,40],g=jQuery("<select></select>");jQuery("#minimizedItemSize").append(g);for(Q=0;Q<b.length;Q+=1){n=b[Q];g.append(jQuery("<option value='"+n+"' "+(4==n?"selected":"")+" >"+n+"</option>"))}jQuery("#minimizedItemSize").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});y=jQuery("#minimizedItemShapeType");for(var i in primitives.common.ShapeType){n=primitives.common.ShapeType[i];y.append(jQuery("<br/><label><input aria-label='label' name='minimizedItemShapeType' type='radio' value='"+n+"' "+(n==primitives.common.ShapeType.None?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=minimizedItemShapeType]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var f=[0,1,2,3,4,5,6,7,8,9,10],I=jQuery("<select></select>");jQuery("#minimizedItemLineWidth").append(I);for(Q=0;Q<f.length;Q+=1){n=f[Q];I.append(jQuery("<option value='"+n+"' "+(1==n?"selected":"")+" >"+n+"</option>"))}jQuery("#minimizedItemLineWidth").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});y=jQuery("#minimizedItemLineType");for(var i in primitives.common.LineType){n=primitives.common.LineType[i];y.append(jQuery("<br/><label><input aria-label='label' name='minimizedItemLineType' type='radio' value='"+n+"' "+(n==primitives.common.LineType.Solid?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=minimizedItemLineType]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var T=jQuery("<select></select>");for(var i in T.append(jQuery("<option value='' selected>null</option>")),jQuery("#minimizedItemBorderColor").append(T),primitives.common.Colors){n=primitives.common.Colors[i];T.append(jQuery("<option value='"+n+"'>"+i+"</option>"))}jQuery("#minimizedItemBorderColor").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var U=jQuery("<select></select>");for(var i in U.append(jQuery("<option value='' selected>null</option>")),jQuery("#minimizedItemFillColor").append(U),primitives.common.Colors){n=primitives.common.Colors[i];U.append(jQuery("<option value='"+n+"'>"+i+"</option>"))}jQuery("#minimizedItemFillColor").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var C=[0,.1,.2,.3,.4,.5,.6,.7,.8,.9,1],M=jQuery("<select></select>");jQuery("#minimizedItemOpacity").append(M);for(Q=0;Q<C.length;Q+=1){n=C[Q];M.append(jQuery("<option value='"+n+"' "+(1==n?"selected":"")+" >"+n+"</option>"))}jQuery("#minimizedItemOpacity").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var k=[1,2,3,4,5,6,7,8,9,10],z=jQuery("<select></select>");jQuery("#highlightPadding").append(z);for(Q=0;Q<k.length;Q+=1){n=k[Q];z.append(jQuery("<option value='"+n+"' "+(2==n?"selected":"")+" >"+n+"</option>"))}jQuery("#highlightPadding").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var S=["normalLevelShift","dotLevelShift","lineLevelShift","normalItemsInterval","dotItemsInterval","lineItemsInterval","cousinsIntervalMultiplier"],P=[1,2,3,4,5,6,7,8,9,10,12,14,16,18,20,30,40],L=new primitives.orgdiagram.Config;L.dotItemsInterval=2;for(var R=0;R<S.length;R++){var w=S[R],D=jQuery("<select></select>");jQuery("#"+w).append(D);for(Q=0;Q<P.length;Q+=1){n=P[Q];var x=L[w];D.append(jQuery("<option value='"+n+"' "+(n==x?"selected":"")+" >"+n+"</option>"))}jQuery("#"+w).change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)})}var G=[1,2,3,4,5,6,7,8,9,10],A=jQuery("<select></select>");jQuery("#lineWidth").append(A);for(Q=0;Q<G.length;Q+=1){n=G[Q];A.append(jQuery("<option value='"+n+"' "+(1==n?"selected":"")+" >"+n+"</option>"))}jQuery("#lineWidth").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var O=jQuery("#showLabels");for(var i in primitives.common.Enabled){n=primitives.common.Enabled[i];O.append(jQuery("<br/><label><input aria-label='label' name='showLabels' type='radio' value='"+n+"' "+(n==primitives.common.Enabled.Auto?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=showLabels]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var F=jQuery("#labelOrientation");for(var i in primitives.text.TextOrientationType){n=primitives.text.TextOrientationType[i];F.append(jQuery("<br/><label><input aria-label='label' name='labelOrientation' type='radio' value='"+n+"' "+(n==primitives.text.TextOrientationType.Horizontal?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=labelOrientation]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var V=jQuery("#labelPlacement");for(var i in primitives.common.PlacementType){n=primitives.common.PlacementType[i];V.append(jQuery("<br/><label><input aria-label='label' name='labelPlacement' type='radio' value='"+n+"' "+(n==primitives.common.PlacementType.Top?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=labelPlacement]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)});var B=jQuery("#graphicsType");for(var i in primitives.common.GraphicsType){n=primitives.common.GraphicsType[i];B.append(jQuery("<br/><label><input aria-label='label' name='graphicsType' type='radio' value='"+n+"' "+(n==primitives.common.GraphicsType.SVG?"checked":"")+" />"+i+"</label>"))}jQuery("input:radio[name=graphicsType]").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Recreate)});var _=[.5,.6,.7,.8,.9,1,1.1,1.2,1.3,1.4,1.5,1.6,1.7,1.8,1.9,2],N=jQuery("<select></select>");jQuery("#cssScale").append(N);for(Q=0;Q<_.length;Q+=1){n=_[Q];N.append(jQuery("<option value='"+n+"' "+(1==n?"selected":"")+" >"+Math.round(100*n)+"%</option>"))}jQuery("#cssScale").change(function(){Update(jQuery("#centerpanel"),primitives.common.UpdateMode.Refresh)}),Setup(jQuery("#centerpanel")),LoadData(jQuery("#centerpanel"))});
</script>

<?php
$matrix_id = isset($_GET['sub1']) ? htmlspecialchars($_GET['sub1'], ENT_QUOTES, 'UTF-8') : '';
?>
<script type="text/javascript">
    function getContactTemplate() {
        var result = new primitives.orgdiagram.TemplateConfig();
        result.name = "contactTemplate";
        result.itemSize = new primitives.common.Size(220, 120);
        var minimizedItemSize = parseInt(jQuery("#minimizedItemSize option:selected").val(), 10);
        result.minimizedItemSize = new primitives.common.Size(minimizedItemSize, minimizedItemSize);
        var highlightPadding = parseInt(jQuery("#highlightPadding option:selected").val(), 10);
        result.highlightPadding = new primitives.common.Thickness(highlightPadding, highlightPadding, highlightPadding, highlightPadding);
        result.minimizedItemShapeType = parseInt(jQuery("input:radio[name=minimizedItemShapeType]:checked").val(), 10);
        result.minimizedItemLineWidth = parseInt(jQuery("#minimizedItemLineWidth option:selected").val(), 10);
        result.minimizedItemLineType = parseInt(jQuery("input:radio[name=minimizedItemLineType]:checked").val(), 10);
        result.minimizedItemBorderColor = jQuery("#minimizedItemBorderColor option:selected").val();
        result.minimizedItemFillColor = jQuery("#minimizedItemFillColor option:selected").val();
        result.minimizedItemOpacity = parseFloat(jQuery("#minimizedItemOpacity option:selected").val());
        var minimizedItemCornerRadius = parseInt(jQuery("#minimizedItemCornerRadius option:selected").val(), 10);
        result.minimizedItemCornerRadius = minimizedItemCornerRadius == -1 ? null : minimizedItemCornerRadius;
        var itemTemplate = jQuery(
            '<div class="bp-item bp-corner-all bt-item-frame">'
            + '<div name="titleBackground" class="bp-item bp-corner-all bp-title-frame" style="top: 2px; left: 2px; width: 216px; height: 20px;">'
            + '<div name="title" class="bp-item bp-title" style="top: 3px; left: 6px; width: 208px; height: 18px;">'
            + '</div>'
            + '</div>'
            + '<div class="bp-item bp-photo-frame" style="top: 26px; left: 2px; width: 50px; height: 60px;">'
            + '<img alt="image" name="photo" style="height: 60px; width:50px;" />'
            + '</div>'
            + '<div class="bp-item bp-rankphoto-frame" style="top: 26px; left: 2px; width: 50px; height: 60px;">'
            + '<img alt="image" name="rankphoto" style="height: 60px; width:50px;" />'
            + '</div>'
            + '<div class="ge_contt">' + '<div name="phone" class="bp-item" style="top: 26px; left: 56px; width: 162px; height: 18px; font-size: 12px;"></div>'
            + '<div class="bp-item" style="top: 44px; left: 56px; width: 162px; height: 18px; font-size: 12px;"><a aria-label="link" name="email" href="" target="_top"></a></div>'
            + '<div name="rank" class="bp-item" style="top: 26px; left: 56px; width: 162px; height: 18px; font-size: 12px;"></div>'
            + '<div name="description" class="bp-item" style="top: 70px; left: 56px; width: 162px; height: 36px; font-size: 10px;"></div>'
            + '</div>'
        ).css({
            width: result.itemSize.width + "px",
            height: result.itemSize.height + "px"
        }).addClass("bp-item bp-corner-all bt-item-frame");
        result.itemTemplate = itemTemplate.wrap('<div>').parent().html();
        return result;
    }
    function getContactTemplate1() {
        var result = new primitives.orgdiagram.TemplateConfig();
        result.name = "contactTemplate1";
        result.itemSize = new primitives.common.Size(220, 120);
        var minimizedItemSize = parseInt(jQuery("#minimizedItemSize option:selected").val(), 10);
        result.minimizedItemSize = new primitives.common.Size(minimizedItemSize, minimizedItemSize);
        var highlightPadding = parseInt(jQuery("#highlightPadding option:selected").val(), 10);
        result.highlightPadding = new primitives.common.Thickness(highlightPadding, highlightPadding, highlightPadding, highlightPadding);
        result.minimizedItemShapeType = parseInt(jQuery("input:radio[name=minimizedItemShapeType]:checked").val(), 10);
        result.minimizedItemLineWidth = parseInt(jQuery("#minimizedItemLineWidth option:selected").val(), 10);
        result.minimizedItemLineType = parseInt(jQuery("input:radio[name=minimizedItemLineType]:checked").val(), 10);
        result.minimizedItemBorderColor = jQuery("#minimizedItemBorderColor option:selected").val();
        result.minimizedItemFillColor = jQuery("#minimizedItemFillColor option:selected").val();
        result.minimizedItemOpacity = parseFloat(jQuery("#minimizedItemOpacity option:selected").val());
        var minimizedItemCornerRadius = parseInt(jQuery("#minimizedItemCornerRadius option:selected").val(), 10);
        result.minimizedItemCornerRadius = minimizedItemCornerRadius == -1 ? null : minimizedItemCornerRadius;
        var itemTemplate = jQuery(
            '<div class="bp-item bp-corner-all bt-item-frame">'
            + '<div name="titleBackground" class="bp-item bp-corner-all bp-title-frame" style="top: 2px; left: 2px; width: 216px; height: 20px;">'
            + '<div name="title" class="bp-item bp-title" style="top: 3px; left: 6px; width: 208px; height: 18px;">'
            + '</div>'
            + '</div>'
            + '<div class="bp-item bp-photo-frame" style="top: 26px; left: 2px; width: 50px; height: 60px;">'
            + '<img alt="image" name="photo" style="height: 60px; width:50px;" />'
            + '</div>'
            + '<div class="ge_contt">' + '<div name="phone" class="bp-item" style="top: 26px; left: 56px; width: 162px; height: 18px; font-size: 12px;"></div>'
            + '<div class="bp-item" style="top: 44px; left: 56px; width: 162px; height: 18px; font-size: 12px;"><a aria-label="link" name="email" href="" target="_top"></a></div>'
            + '<div name="description" class="bp-item" style="top: 80px; left: 56px; width: 162px; height: 36px; font-size: 10px;"></div>'
            + '<div name="rank" class="bp-item" style="top: 100px; left: 18px; width: 162px; height: 18px; font-size: 12px;"></div>'

            + '</div>'
        ).css({
            width: result.itemSize.width + "px",
            height: result.itemSize.height + "px"
        }).addClass("bp-item bp-corner-all bt-item-frame");
        result.itemTemplate = itemTemplate.wrap('<div>').parent().html();
        return result;
    }
    function getContactTemplate2() {
        var result = new primitives.orgdiagram.TemplateConfig();
        result.name = "contactTemplate2";
        result.itemSize = new primitives.common.Size(220, 120);
        var minimizedItemSize = parseInt(jQuery("#minimizedItemSize option:selected").val(), 10);
        result.minimizedItemSize = new primitives.common.Size(minimizedItemSize, minimizedItemSize);
        var highlightPadding = parseInt(jQuery("#highlightPadding option:selected").val(), 10);
        result.highlightPadding = new primitives.common.Thickness(highlightPadding, highlightPadding, highlightPadding, highlightPadding);
        result.minimizedItemShapeType = parseInt(jQuery("input:radio[name=minimizedItemShapeType]:checked").val(), 10);
        result.minimizedItemLineWidth = parseInt(jQuery("#minimizedItemLineWidth option:selected").val(), 10);
        result.minimizedItemLineType = parseInt(jQuery("input:radio[name=minimizedItemLineType]:checked").val(), 10);
        result.minimizedItemBorderColor = jQuery("#minimizedItemBorderColor option:selected").val();
        result.minimizedItemFillColor = jQuery("#minimizedItemFillColor option:selected").val();
        result.minimizedItemOpacity = parseFloat(jQuery("#minimizedItemOpacity option:selected").val());
        var minimizedItemCornerRadius = parseInt(jQuery("#minimizedItemCornerRadius option:selected").val(), 10);
        result.minimizedItemCornerRadius = minimizedItemCornerRadius == -1 ? null : minimizedItemCornerRadius;
        var itemTemplate = jQuery(
            '<div class="bp-item bp-corner-all bt-item-frame">'
            + '<div name="titleBackground" class="bp-item bp-corner-all bp-title-frame emptyaddmann" style="top: 2px; left: 2px; width: 216px; height: 20px;">'
            + '<div name="title" class="bp-item bp-title " style="top: 3px; left: 6px; width: 208px; height: 18px;">'
            + '</div>'
            + '</div>'
            + '<div class="bp-item bp-photo-frame" style="top: 26px; left: 2px; width: 50px; height: 60px;">'
            + '<a aria-label="link" name="photo" href="" target="_blank" rel="noopener" ><img alt="image" name="photo" style="height: 60px; width:50px;" /></a>'
            + '</div>'
            + '</div>'
        ).css({
            width: result.itemSize.width + "px",
            height: result.itemSize.height + "px"
        }).addClass("bp-item bp-corner-all bt-item-frame");
        result.itemTemplate = itemTemplate.wrap('<div>').parent().html();
        return result;
    }
    function onTemplateRender(event, data) {
        switch (data.renderingMode) {
            case primitives.common.RenderingMode.Create:
                data.element.find("[name=email]").click(function (e) {
                    /* Block mouse click propogation in order to avoid layout updates before server postback*/
                    primitives.common.stopPropagation(e);
                });
                /* Initialize widgets here */
                break;
            case primitives.common.RenderingMode.Update:
                /* Update widgets here */
                break;
        }
        var itemConfig = data.context,
            itemTitleColor = itemConfig.itemTitleColor != null ? itemConfig.itemTitleColor : primitives.common.Colors.RoyalBlue;
        if (data.templateName == "contactTemplate") {
            data.element.find("[name=photo]").attr({ "src": itemConfig.image });
            data.element.find("[name=photo]").attr({ "href": "#" });
            data.element.find("[name=rankphoto]").attr({ "src": itemConfig.rankimage });
            data.element.find("[name=titleBackground]").css({ "background": itemTitleColor });
            data.element.find("[name=email]").attr({ "href": ("mailto:" + itemConfig.email + "?Subject=Hello%20world") });

            var fields = ["id", "title", "description", "phone", "email", "rank"];
            for (var index = 0; index < fields.length; index += 1) {
                var field = fields[index];
                var element = data.element.find("[name=" + field + "]");
                if (element.text() != itemConfig[field]) {
                    element.text(itemConfig[field]);
                }
            }
        }
        if (data.templateName == "contactTemplate1") {
            data.element.find("[name=photo]").attr({ "src": itemConfig.image });
            data.element.find("[name=photo]").attr({ "href": ("{{$_ENV['FCPATH']}}/memberarea/show/" + itemConfig.id) });
            data.element.find("[name=titleBackground]").css({ "background": itemTitleColor });
            data.element.find("[name=email]").attr({ "href": ("mailto:" + itemConfig.email + "?Subject=Hello%20world") });

            var fields = ["id", "title", "description", "phone", "email", "rank", "changeinterposition"];
            for (var index = 0; index < fields.length; index += 1) {
                var field = fields[index];
                var element = data.element.find("[name=" + field + "]");
                if (element.text() != itemConfig[field]) {
                    element.text(itemConfig[field]);
                }
            }
        }
    }
    function toggleFullscreen(elem) {
        elem = elem || document.documentElement;
        if (!document.fullscreenElement && !document.mozFullScreenElement &&
            !document.webkitFullscreenElement && !document.msFullscreenElement) {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        }
    }
    document.getElementById('fullscreen').addEventListener('click', function () {
        toggleFullscreen(contentpanel);
    });
   

    function genealogySearch() {
            const membersUsername = document.querySelector('#searchbox').value;
            const encryptUrl = "{{ $sub1 }}"; // Blade syntax for injecting PHP variables

            if (membersUsername !== '') {
                fetch("{{$_ENV['BCPATH']}}/genealogy/search", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        members_username: membersUsername,
                        encrypturl: encryptUrl,
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.text();
                })
                .then(data => {

                    window.location.href = `{{$_ENV['BCPATH']}}/genealogy/viewtree/${data}`;
                })
                .catch(error => {
                    console.error("Error occurred during genealogy search:", error);
                });
            }
        }

function filterSuggestions(query) {
    const suggestionBox = document.getElementById("suggestion-box");
    const items = suggestionBox.querySelectorAll("div[data-value]");

    if (query.trim() === "") {
        suggestionBox.classList.add("hidden");
        return;
    }

    const matrixId = "{{ $matrix_id }}";
    
    // Fetch members based on the query
    fetch(`{{$_ENV['BCPATH']}}/genealogy/getmembers/${query}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ matrix_id: matrixId }),
    })
    .then((response) => response.json())
    .then((data) => {
        // Clear previous suggestions
        suggestionBox.innerHTML = "";

        if (data.length === 0) {
            suggestionBox.classList.add("hidden");
            return;
        }

        // Populate suggestions dynamically
        data.forEach((member) => {
            const div = document.createElement("div");
            div.textContent = member.members_username; // Adjust based on API response
            div.dataset.value = member.members_id; // Adjust based on API response
            div.dataset.namevalue = member.members_username; 
            div.classList.add("suggestion-item", "cursor-pointer", "p-2", "hover:bg-neutral-200");

            // Add click event to select the suggestion
            div.addEventListener("click", () => {
                document.getElementById("searchbox").value = div.dataset.namevalue; // Adjust field based on API
                suggestionBox.classList.add("hidden");
                document.querySelector('#members_id').value = div.dataset.value;
            });

            suggestionBox.appendChild(div);
        });

        suggestionBox.classList.remove("hidden");
    })
    .catch((error) => {
        console.error("Error fetching suggestions:", error);
    });

}
function selectSuggestion(value) {
    const input = document.querySelector("[data-hs-combo-box-input]");
    input.value = value;

    const suggestionBox = document.getElementById("suggestion-box");
    suggestionBox.classList.add("hidden");
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
                window.location.href = "{{$_ENV['BCPATH']}}/grpgenealogy/viewtree/"+data;
            })
            .catch(error => {
                console.error("Error:", error);
                // Handle errors if necessary
                // document.getElementById('preloader').style.display = "none"; // Hide preloader on error
            });
        }
    });

</script>
<!--end::MLM CustomPage Scripts -->