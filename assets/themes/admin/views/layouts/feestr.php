<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title><?php echo $template['title']; ?></title>
        <?php echo theme_css('select2/select2.css'); ?>
        <?php echo theme_js('plugins/jquery/jquery.min.js'); ?>
        <?php echo theme_js('select2/select2.min.js'); ?>
        <?php echo theme_css('hub.css'); ?>
        <script type="text/javascript">
                $(function ()
                {
                    $(".select").select2({'placeholder': 'Please Select', 'width': '500px'});
                });

        </script>

    </head>
    <body style="background: rgb(232, 234, 237);color: #333; font-weight: lighter;padding-bottom: 60px;">
        <div id="page" style="background: #ffffff;width: 66.7%;margin: 0 auto;margin-top: 80px;margin-bottom: 80px;display: block;border: 1px solid #c4c7c7;padding:0px;position: relative;z-index: 0;">
            <div class="right">
                <?php echo form_open('admin/fee_structure/fee_hub/'); ?> 
                <select name="student" class="select" tabindex="-1">
                    <option value="">Select Student</option>
                    <?php
                    $data = $this->ion_auth->students_full_details();
                    foreach ($data as $key => $value):
                            ?>
                            <option value="<?php echo $key; ?>"><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-warning"  style="height:30px;" type="submit">View</button>
                </form>
            </div>

            <div style="background-color:#B94A48 !important; border-top:#59baff solid 2px; border-bottom:#59baff solid 2px; padding-right:10px;color:#fff; 
                 padding-left:10px; padding-top:20px; text-decoration:none;font-size:22px;font-weight:bold;margin-bottom:0px; height:50px; ">
                FEE PAYMENT & FEE STRUCTURE
            </div>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="margin: 0px" bgcolor="#ffffff" width="100%">
                        <table width="90%" cellpadding="0" cellspacing="0" border="0" align="center" style="background-color:#ffffff; font-size:14px; color: #7c7c7c">
                            <tr>
                                <td valign="top">
                                    <tr>
                                        <td valign="top" style=" font-size:14px; color: #7c7c7c; line-height:1.7em;  padding:10px;">
                                            <h4>Dear Parent, </h4>

                                            <p class="place">Greetings, Please find below next terms invoice.</p>
                                                
                                            <div id="page-wrap">
                                                <textarea id="header">INVOICE</textarea>
                                                <div id="identity">
                                                    <?php $kd = $this->worker->get_student($id);?>
                                                     Fee For:<br><?php echo $kd->first_name. ' '.$kd->last_name; ?><br>
                                                        <?php echo $kd->email; ?><br>
                                                        <?php echo $kd->phone; ?><br>
                                                        <?php echo $kd->address; ?> 

                                                    <div id="logo">
                                                        <img id="image" src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" alt="logo" />
                                                    </div>

                                                </div>

                                                <div style="clear:both"></div>

                                                <div id="customer">

                                                    <textarea id="customer-title"><?php echo $this->school->school; ?></textarea>

                                                    <table id="meta">
                                                        <tr>
                                                            <td class="meta-head">Invoice #</td>
                                                            <td> <?php echo $inov; ?></td>
                                                        </tr>
                                                        <tr>

                                                            <td class="meta-head">Date</td>
                                                            <td> <?php echo date('jS F Y'); ?> </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="meta-head"> &nbsp;</td>
                                                            <td><div class="due"> </div></td>
                                                        </tr>

                                                    </table>

                                                </div>

                                                <table id="items">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Description</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                    <?php
                                                    $i = 0;
                                                    $tot = 0;
                                                    $extra = 0;
                                                    $arr = isset($bal->balance) ? $bal->balance : 0;
                                                    foreach ($payload as $yr => $fees)
                                                    {
                                                            foreach ($fees as $term => $row)
                                                            {
                                                                    foreach ($row as $title => $specs)
                                                                    {
                                                                            if ($title === 'Extra')
                                                                            {
                                                                                    foreach ($specs as $dkey => $dspec)
                                                                                    {
                                                                                            $ds = (object) $dspec;
                                                                                            $extra += $ds->amount;
                                                                                    }
                                                                            }

                                                                            foreach ($specs as $key => $spec)
                                                                            {
                                                                                    $s = (object) $spec;
                                                                                    $tot += $s->amount;
                                                                                    $i++;
                                                                                    ?>
                                                                                    <tr class="item-row">
                                                                                        <td width="5%"><?php echo $i; ?>. </td>
                                                                                        <td  width="25%"> <?php echo $s->date > 10000 ? date('d M Y', $s->date) : ' - '; ?> </td>
                                                                                        <td class="description"> <?php echo $s->desc; ?>  </td>
                                                                                        <td  width="25%" class="amt"><?php echo number_format($s->amount, 2); ?> </td>
                                                                                    </tr>
                                                                                    <?php
                                                                            }
                                                                    }
                                                            }
                                                    }
                                                    $actual = $arr - $extra;
                                                    ?>
                                                    <tr>
                                                        <td colspan="2" class="blank"> </td>
                                                        <td class="total-line">Subtotal:</td>
                                                        <td class="amt"> <strong><?php echo number_format($tot, 2); ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="blank"> </td>
                                                        <td class="total-line">Current Fee Arrears:</td>
                                                        <td class="amt"><strong><?php echo number_format($actual, 2); ?></strong></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2" class="blank"> </td>
                                                        <td class="total-line balance">Total Due:</td>
                                                        <td class="total-value balance amt"><strong><?php echo number_format(($tot + $actual), 2); ?></strong></td>
                                                    </tr>

                                                </table>



                                            </div>

                                            <hr/>

                                            <h4>
                                                Thank you  for choosing <?php echo $this->school->school; ?>.
                                            </h4>

                                        </td>
                                    </tr>
                                </td>
                            </tr>
                            <tr>
                                <td height="20">
                                </td>
                            </tr>
                        </table>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="background-color:#B94A48 !important; color:#cacacc; border-top:#59baff solid 2px;">
                            <tr>
                                <td align="center" style=" font-size:12px; color: #cacacc;">

                                    <p style="line-height:160%; ">You received this message because you registered as a parent/Guardian.</p>
                                    <?php echo $this->school->school; ?>   |  <?php echo $this->school->postal_addr; ?>  | <?php echo $this->school->email; ?>  </p>
                                    <p>© <?php echo date('Y'); ?> <a href="http://www.smartshule.com">Smart Shule</a> All Rights Reserved.</p>
                                </td>
                            </tr>
                        </table>

                        <!-- footer ends -->
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
