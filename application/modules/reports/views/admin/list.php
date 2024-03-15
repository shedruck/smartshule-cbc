<?php
$message = $this->session->flashdata('message');
if ($message)
{
    if (is_array($message['text']))
    {
        if ($message['type'] == "success")
        {
            echo '<div class="alert alert-success fade in">
	 <button data-dismiss="alert" class="close" type="button">×</button>
	 <strong>Success\!</strong>';
            echo "<ul>";
            foreach ($message['text'] as $msg)
            {
                echo "<li><span>" . $msg . "</span></li>";
            }

            echo "<ul>
	 </div>";
        }
        elseif ($message['type'] == "error")
        {
            echo '<div class="alert alert-error fade in">
	 <button data-dismiss="alert" class="close" type="button">×</button>
	 <strong>Error!</strong>';
            echo "<ul>";
            foreach ($message['text'] as $msg)
            {
                echo "<li><span>" . $msg . "</span></li>";
            }

            echo "<ul>
	 </div>";
        }
    }
    else
    {
        echo '<div class="alert alert-success fade in">
	 <button data-dismiss="alert" class="close" type="button">×</button>
	 <strong>' . ucwords($message['type']) . '!</strong><br>';
        echo "<span>" . $message['text'] . "</span>            
	 </div>";
    }
}
?>

<div class="row">
    <div class="col-md-10 widget-container-span ui-sortable">
        <div class="widget-box" style="opacity: 1; z-index: 0;">   
            <div class="widget-header"> <h5>Reports </h5>
                <div class="widget-toolbar"> 
                    <span class="badge badge-success">
                        <?php echo anchor('admin/reports/create/' . $page, '<i class="glyphicon glyphicon-plus">
                    </i>' . lang('web_create_t', array(':name' => 'reports'))); ?>                  
                    </span><a href="#" data-action="collapse"> <i class="glyphicon glyphicon-chevron-up"></i> </a>
                </div>
            </div>

            <div class="widget-body">    <div class="widget-main">

                    <?php if ($reports): ?>
                        <div class='space-6'></div>

                        <table class="table table-striped table-bordered table-hover dataTable">
                            <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th colspan='2'><?php echo lang('web_options'); ?></th>
                            </thead>
                            <tbody>
                                <?php foreach ($reports as $reports_m): ?>
                                    <tr>					<td><?php echo $reports_m->name; ?></td>
                                        <td><?php echo $reports_m->description; ?></td>
                                        <td width='60'><a class='btn-blue btn btn-small' href='<?php echo site_url(); ?>admin/reports/edit/<?php echo $reports_m->id ?>/<?php echo $page ?>'><?php echo lang('web_edit'); ?></a></td>
                                        <td width='60'><a class='btn btn-small' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url(); ?>admin/reports/delete/<?php echo $reports_m->id; ?>/<?php echo $page; ?>'><?php echo lang('web_delete') ?></a></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>

                        </table>

                        <?php echo $links; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php else: ?>
    <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?>
<div id="space" style="width:100%; height:400px;"></div>

<script>

                                    var talkingAboutThis = [], d = [4.3, 5.1, 4.3, 5.2, 5.4, 4.7, 3.5, 4.1, 5.6, 7.4, 6.9, 7.1,
                                        7.9, 7.9, 7.5, 6.7, 7.7, 7.7, 7.4, 7.0, 7.1, 5.8, 5.9, 7.4,
                                        8.2, 8.5, 9.4, 8.1, 10.9, 10.4, 10.9, 12.4, 12.1, 9.5, 7.5,
                                        7.1, 7.5, 8.1, 6.8, 3.4, 2.1, 1.9, 2.8, 2.9, 1.3, 4.4, 4.2,
                                        3.0, 3.0],
                                            newLikes = [], d1 = [0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.1, 0.0, 0.3, 0.0,
                                        0.0, 0.4, 0.0, 0.1, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0,
                                        0.0, 0.6, 1.2, 1.7, 0.7, 2.9, 4.1, 2.6, 3.7, 3.9, 1.7, 2.3,
                                        3.0, 3.3, 4.8, 5.0, 4.8, 5.0, 3.2, 2.0, 0.9, 0.4, 0.3, 0.5, 0.4],
                                            target = $('#space'),
                                            plot = null;
                                    for (var i in d) {
                                        var dd = new Date(Date.UTC(2012, 6, parseInt(i, 10) + 1));
                                        talkingAboutThis.push([dd.getTime(), d[i]]);
                                    }
                                    for (var i in d1) {
                                        var dd = new Date(Date.UTC(2012, 6, parseInt(i, 10) + 1));
                                        newLikes.push([dd.getTime(), d1[i]]);
                                    }

                                    var options = {
                                        series: {
                                            lines: {
                                                show: true,
                                                fill: true,
                                                lineWidth: 2,
                                                steps: false,
                                                fillColor: {colors: [{opacity: 0.25}, {opacity: 0}]}
                                            },
                                            points: {
                                                show: true,
                                                radius: 4,
                                                fill: true,
                                                lineWidth: 2
                                            }
                                        },
                                        tooltip: true,
                                        tooltipOpts: {
                                            content: '%s: %y'
                                        },
                                        xaxis: {mode: "time"},
                                        grid: {borderWidth: 0, hoverable: true},
                                        legend: {
                                            show: false
                                        }
                                    },
                                    data = [{
                                            data: talkingAboutThis,
                                            label: 'Sales this month',
                                            color: '#77aae9',
                                            lines: {lineWidth: 1}
                                        }, {
                                            data: newLikes,
                                            label: 'Profit this month',
                                            color: '#f36a30',
                                            points: {show: false},
                                            lines: {lineWidth: 2, fill: false}
                                        }];
                                    function showTooltip(x, y, contents) {
                                        $('<div id="tooltip">' + contents + '</div>').css({
                                            position: 'absolute',
                                            display: 'none',
                                            //float: 'left',
                                            top: y - 40,
                                            left: x - 30,
                                            color: '#cccccc',
                                            fontSize: '11px',
                                            fontFamily: 'Arial',
                                            fontWeight: 'normal',
                                            padding: '4px 10px',
                                            'background-color': 'rgba(47, 47, 47, 0.8)'
                                        }).appendTo("body").fadeIn(200);
                                    }


                                    var previousPoint = null;
                                    $(target).bind("plothover", function(event, pos, item) {
                                        $("#x").text(pos.x.toFixed(2));
                                        $("#y").text(pos.y.toFixed(2));
                                        if (item) {
                                            if (previousPoint != item.dataIndex) {
                                                previousPoint = item.dataIndex;
                                                $("#tooltip").remove();
                                                var x = item.datapoint[0].toFixed(2),
                                                        y = item.datapoint[1].toFixed(2);
                                                showTooltip(item.pageX, item.pageY,
                                                        item.series.label + " = " + y);
                                            }
                                        }
                                        else {
                                            $("#tooltip").remove();
                                            previousPoint = null;
                                        }

                                    });
                                    // define the plotting function to call each time the tab is shown
                                    function plotNow() {
                                        plot || (plot = $.plot(target, data, options));
                                    }
                                    $(document).ready(function()
                                    {
                                        plotNow()
                                    });

</script>