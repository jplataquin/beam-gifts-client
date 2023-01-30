@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Frequenty Asked Questions (FAQ)</h1>
    

    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: How to claim a E-gift?
        </div>    
        <div class="fs-2">
            A: The receiver of the E-gift can present the QR code to the establishment in order to claim the item. 
            For more details please check the "<a href="/how-to-claim">how to claim</a>" page.
        </div>
    </div>


    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: What happens if I sent the E-gift to the wrong person?
        </div>    
        <div class="fs-2">
            A: Unfortnately the responsiblity of securing and sending the E-gift falls in the hands of the user who bought and sent it.
            Currently Beam Gifts does not have any password protection or security measure to prevent such mistake from happening. 
        </div>
    </div>
    
    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: Is it safe to share my E-gift QR code publicly or online?
        </div>    
        <div class="fs-2">
            A: No, please keep the QR code confidential from other people. 
            Sharing the QR code publicly or online can result in someone gaining control of the E-gift.
        </div>
    </div>


    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: What happens if the E-gift I want to claim is not available or is out of stock.
        </div>    
        <div class="fs-2">
            A: All E-gift items can be substituted for another item with equal or lesser value upon cliaming. 
            Note that no monetary change is given for items with lesser value.
        </div>
    </div>


    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: Can I request to change the QR code of the E-gift?
        </div>    
        <div class="fs-2">
            A: No, Each E-gift has a unique QR code and once generated it cannot be changed.
        </div>
    </div>
    
    
    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: How do I refund a E-gift item?
        </div>    
        <div class="fs-2">
            A: Only the user who bought the E-gift can request for a refund. 
            In order to initiate the process, please email us using your registered email at "refund@beam.gifts".
            Note that refunds are subject to our <a href="/tos">terms of service</a>, and due to third party payment providers we will not be able to refund
            the entire amount.
        </div>
    </div>


    <div class="mb-5 bg-white p-3">
        <div class="mb-3 fw-bold fs-4">
            Q: What happens if the brand or service is no longer available and my E-gift has not yet been claimed.
        </div>    
        <div class="fs-3">
            A: In the event that the brand or service has closed down or no longer exists, the user who bought the E-gift can request for a refund.
            Note that the E-gift must not be expired and is subject to the conditions in our <a href="/tos">terms of service</a>,.
        </div>
    </div>

</div>


@endsection