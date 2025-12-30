@extends('user::components.common.main')
@section('content')
<!-- breadcrub navs start-->
<!-- Content area -->
<main class="flex-grow">
            <!--start-content-->
    @include('user::dashboard.components.dashboard_block1')
    @include('user::dashboard.components.frontline_popup')
    @include('user::dashboard.components.downline_popup')
    @include('user::dashboard.components.direct_downline_popup')
    @include('user::dashboard.components.packagepurchased_popup')
    @include('user::dashboard.components.orders_popup')
    @include('user::dashboard.components.totalcommissions_popup')
    @include('user::dashboard.components.pvstats_popup')
    @include('user::dashboard.components.gpvstats_popup')
    @include('user::dashboard.components.activememberstats_popup')
    @include('user::dashboard.components.paidaccountstats_popup')
    @include('user::dashboard.components.walletamount_popup')
    @include('user::dashboard.components.cwalletamount_popup')
    @include('user::dashboard.components.payoutdetails_popup')
    @include('user::dashboard.components.downlinesalesdetails_popup')
    @include('user::dashboard.components.dashboard_rankwizardpopup')

</main>

@endsection
<script>
const replicateUrl="{{$block1details['replicated_url']}}";
const referralUrl="{{$block1details['referral_link']}}";
</script>
