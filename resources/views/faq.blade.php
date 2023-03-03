@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="mt-3 ">Frequenty Asked Questions (FAQ)</h1>
    

    <div class="mb-3 bg-white p-3 rounded border-darkmagenta">
        <div class="mb-3 fw-bold fs-4">
            Q: How do you claim an E-gift?
        </div>    
        <div class="fs-5">
            A: The recipient shall present the QR code to the establishment before the gift is released.
            
            For more details on how to claim please visit the "<a href="/how-to-claim">how to claim</a>" page.
        </div>
    </div>


    <div class="mb-3 bg-white p-3 rounded border-darkmagenta">
        <div class="mb-3 fw-bold fs-4">
            Q: What if I sent the gift to the wrong person?
        </div>    
        <div class="fs-5">
            A: The person who bought the gift is solely responsible for securing and correctly sending the link to the right person.
            There is currently no feature to retrieve or void the link in case the gift was sent to the wrong person. 
        </div>
    </div>
    
    <div class="mb-3 bg-white p-3 rounded border-darkmagenta">
        <div class="mb-3 fw-bold fs-4">
            Q: Is it safe to share my gift link (QR Code) publicly?
        </div>    
        <div class="fs-2">
            A: No, please keep the link or QR code confidential. 
            Sharing the link or QR code publicly can result in the gift being stolen.
        </div>
    </div>


    <div class="mb-3 bg-white p-3 rounded border-darkmagenta">
        <div class="mb-3 fw-bold fs-4">
            Q: What happens if the gift I want to claim is not available or is out of stock.
        </div>    
        <div class="fs-5">
            A: All gift items can be substituted for another item with equal or lesser value upon cliaming. 
            Note that no monetary change is given for items with lesser value.
        </div>
    </div>


    <div class="mb-3 bg-white p-3 rounded border-darkmagenta">
        <div class="mb-3 fw-bold fs-4">
            Q: Can I request to change the QR code of my gift link?
        </div>    
        <div class="fs-5">
            A: No, Each gift has a unique QR code and once generated it cannot be changed.
        </div>
    </div>
    
    
    <div class="mb-3 bg-white p-3 rounded border-darkmagenta">
        <div class="mb-3 fw-bold fs-4">
            Q: How do I refund a gift item?
        </div>    
        <div class="fs-5">
            A: Only the user who bought the gift can request for a refund. 
            In order to initiate the process, please email us using your registered email to "refund@beam.gifts".
            Note that refunds are subject to our <a href="/tos">terms of service</a>, and due to third party payment providers we will not be able to refund
            the entire amount.
        </div>
    </div>


    <div class="mb-3 bg-white p-3 rounded border-darkmagenta">
        <div class="mb-3 fw-bold fs-4">
            Q: What happens if the brand or establishment is no longer existing.
        </div>    
        <div class="fs-5">
            A: In the event that the brand or establishment has closed down or no longer exists, the user who bought the gift can request for a refund.
            Note that the link must not be expired and shall be subject to our <a href="/tos">terms of service</a>,.
        </div>
    </div>

</div>


@endsection