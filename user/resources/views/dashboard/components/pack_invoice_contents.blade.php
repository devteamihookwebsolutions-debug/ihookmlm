<!-- Header -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
  <tr>
    <td height="20"></td>
  </tr>
  <tr>
    <td>
      <table width="520" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable m-auto" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
        <tr class="hiddenMobile">
          <td height="40"></td>
        </tr>
        <tr class="visibleMobile">
          <td height="30"></td>
        </tr>

        <tr>
          <td>
            <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding m-auto">
              <tbody>
                <tr>
                  <td>
                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                      <tbody>
                        <tr>
                          <td align="left"> <img src="{{$base64_site_logo}}" width="150" height="auto" alt="logo" border="0">
                        </td>
                        </tr>
                        <tr class="hiddenMobile">
                          <td height="40"></td>
                        </tr>
                        <tr class="visibleMobile">
                          <td height="20"></td>
                        </tr>
                        <tr>
                          <td style="font-size: 12px; color: #5b5b5b; font-family: 'Inter', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                            Hello, {{$invoicedetails['memberData']['fullname']}}.
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                      <tbody>
                        <tr class="visibleMobile">
                          <td height="20"></td>
                        </tr>
                        <tr>
                          <td height="5"></td>
                        </tr>
                        <tr>
                          <td style="font-size: 21px; color: #000000; letter-spacing: -1px; font-family: 'Inter', sans-serif; line-height: 1; vertical-align: top; text-align: right; text-transform: uppercase; font-weight: bold;">
                            Invoice
                          </td>
                        </tr>
                        <tr>
                        <tr class="hiddenMobile">
                          <td height="50"></td>
                        </tr>
                        <tr class="visibleMobile">
                          <td height="20"></td>
                        </tr>
                        <tr>
                          <td style="font-size: 12px; color: #5b5b5b; font-family:  'Inter', sans-serif; line-height: 22px; vertical-align: top; text-align: right;">
                            <span>Company Name: </span> {{$_SESSION['site_settings']['company_name']}}<br />
                            <span>Invoice Date: </span> {{$invoicedetails['paymentData']['date']}}<br />
                            <span>Order Date: </span> {{$invoicedetails['paymentData']['date']}}<br />
                          
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<!-- /Header -->
<!-- Order Details -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
  <tbody>
    <tr>
      <td>
        <table width="520" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable m-auto" bgcolor="#ffffff">
          <tbody>
            <tr>
            <tr class="hiddenMobile">
              <td height="60"></td>
            </tr>
            <tr class="visibleMobile">
              <td height="40"></td>
            </tr>
            <tr>
              <td>
                <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding m-auto">
                  <tbody>
                    <tr>
                      <th style="font-size: 12px; font-family: 'Inter', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;" width="52%" align="left">
                       <small style="text-transform: uppercase; font-weight: bold;"> Description</small>
                      </th>
                      <th style="font-size: 12px; font-family: 'Inter', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="left">
                        <small style="text-transform: uppercase; font-weight: bold;">Date</small>
                      </th>
                      <th style="font-size: 12px; font-family: 'Inter', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;" align="right">
                     <small style="text-transform: uppercase; font-weight: bold;">  Total</small> 
                      </th>
                    </tr>
                    <tr>
                      <td height="1" style="background: #bebebe;" colspan="4"></td>
                    </tr>
                    <tr>
                      <td height="10" colspan="4"></td>
                    </tr>
                    <tr>
                      <td style="font-size: 12px; font-family: 'Inter', sans-serif; color: #000000;  line-height: 18px;  vertical-align: top; padding:10px 0;" class="article">
                        {{$invoicedetails['packageDetails']['package_name']}} package purchased 
                      </td>
                      <td style="font-size: 12px; font-family: 'Inter', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;">{{$invoicedetails['paymentData']['date']}}</td>

                      <td style="font-size: 12px; font-family: 'Inter', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="right">{{$_SESSION['site_settings']['site_currency']}}{{$invoicedetails['packageDetails']['package_price']}}</td>
                    </tr>
                    <tr>
                      <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
                    </tr>

                    <tr>
                      <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td height="20"></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<!-- /Order Details -->
<!-- Total -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
  <tbody>
    <tr>
      <td>
        <table width="520" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable m-auto" bgcolor="#ffffff">
          <tbody>
            <tr>
              <td>

                <!-- Table Total -->
                <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding m-auto">
                  <tbody>
                    <tr>
                      <td style="font-size: 12px; font-family: 'Inter', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                        Subtotal
                      </td>
                      <td style="font-size: 12px; font-family: 'Inter', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;" width="80">
                        {{$_SESSION['site_settings']['site_currency']}}{{$invoicedetails['paymentData']['amount']}}
                      </td>
                    </tr>
                   
                    <tr>
                      <td style="font-size: 12px; font-family: 'Inter', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                        <strong>Grand Total (Incl.Tax)</strong>
                      </td>
                      <td style="font-size: 12px; font-family: 'Inter', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                        <strong>{{$_SESSION['site_settings']['site_currency']}}{{$invoicedetails['paymentData']['amount']}}</strong>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <!-- /Table Total -->

              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<!-- /Total -->
<!-- Information -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
  <tbody>
    <tr>
      <td>
        <table width="520" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable m-auto" bgcolor="#ffffff">
          <tbody>
            <tr>
            <tr class="hiddenMobile">
              <td height="60"></td>
            </tr>
            <tr class="visibleMobile">
              <td height="40"></td>
            </tr>
            <tr>
              <td>
                <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding m-auto">
                  <tbody>
                    <tr>
                      <td>
                        <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">

                          <tbody>
                            <tr>
                              <td style="font-size: 11px; font-family: 'Inter', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                <strong>BILLING INFORMATION</strong>
                              </td>
                            </tr>
                            <tr>
                              <td width="100%" height="10"></td>
                            </tr>
                            <tr>
                              <td style="font-size: 12px; font-family: 'Inter', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                {{$invoicedetails['memberData']['fullname']}}<br>  {{$invoicedetails['memberData']['address']}}, <br>{{$invoicedetails['memberData']['city']}}<br> {{$invoicedetails['memberData']['state']}}<br> {{$invoicedetails['memberData']['country']}}<br> {{$invoicedetails['memberData']['zip']}}
                              </td>
                            </tr>
                          </tbody>
                        </table>


                        <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                          <tbody>
                            <tr class="visibleMobile">
                              <td height="20"></td>
                            </tr>
                            <tr>
                              <td style="font-size: 11px; font-family: 'Inter', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                <strong>PAYMENT METHOD</strong>
                              </td>
                            </tr>
                            <tr>
                              <td width="100%" height="10"></td>
                            </tr>
                            <tr>
                              <td style="font-size: 12px; font-family: 'Inter', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                {{$invoicedetails['paymentData']['gateway_name']}} <br> Transaction ID: <a href="#" style="color: #000000; text-decoration:underline;">{{$invoicedetails['paymentData']['trans_id']}}</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding m-auto">
                  <tbody>
                    <tr>
                      <td>
                        <table width="220" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
                          <tbody>
                            <tr class="hiddenMobile">
                              <td height="35"></td>
                            </tr>
                            <tr class="visibleMobile">
                              <td height="20"></td>
                            </tr>
                            <tr>
                              <td style="font-size: 11px; font-family: 'Inter', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                <strong>SHIPPING INFORMATION</strong>
                              </td>
                            </tr>
                            <tr>
                              <td width="100%" height="10"></td>
                            </tr>
                            <tr>
                              <td style="font-size: 12px; font-family: 'Inter', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                {{$invoicedetails['memberData']['fullname']}}<br>  {{$invoicedetails['memberData']['address']}}, <br>{{$invoicedetails['memberData']['city']}}<br> {{$invoicedetails['memberData']['state']}}<br> {{$invoicedetails['memberData']['country']}}<br> {{$invoicedetails['memberData']['zip']}}
                              </td>
                            </tr>
                          </tbody>
                        </table>


                        {{-- <table width="220" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
                          <tbody>
                            <tr class="hiddenMobile">
                              <td height="35"></td>
                            </tr>
                            <tr class="visibleMobile">
                              <td height="20"></td>
                            </tr>
                            <tr>
                              <td style="font-size: 11px; font-family: 'Inter', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                <strong>SHIPPING METHOD</strong>
                              </td>
                            </tr>
                            <tr>
                              <td width="100%" height="10"></td>
                            </tr>
                            <tr>
                              <td style="font-size: 12px; font-family: 'Inter', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                UPS: U.S. Shipping Services
                              </td>
                            </tr>
                          </tbody>
                        </table> --}}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr class="hiddenMobile">
              <td height="60"></td>
            </tr>
            <tr class="visibleMobile">
              <td height="30"></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<!-- /Information -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">

  <tr>
    <td>
      <table width="520" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable m-auto" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
        <tr>
          <td>
            <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding m-auto">
              <tbody>
                <tr>
                  <td style="font-size: 12px; color: #5b5b5b; font-family: 'Inter', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                    Have a nice day.
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr class="spacer">
          <td height="50"></td>
        </tr>

      </table>
    </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
</table>