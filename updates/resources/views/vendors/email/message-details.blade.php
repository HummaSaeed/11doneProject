{{-- receipt modal --}}
<div class="modal fade" id="message-{{ $message->id }}" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Message') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
       <textarea  class="form-control" disabled cols="30" rows="10">{{ $message->message }}</textarea>
      </div>

      <div class="modal-footer"></div>
    </div>
  </div>
</div>
