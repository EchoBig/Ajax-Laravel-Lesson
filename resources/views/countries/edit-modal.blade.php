<!-- Modal -->
<div class="modal fade" id="edit-country" tabindex="-1" aria-labelledby="edit-country" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-country">Modal title</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('update.country') }}" method="POST" id="frmUpdateCountry">
          @csrf
          <input type="hidden" name="cid">
          <div class="form-group">
            <label for="country_name">Country Name</label>
            <input type="text" name="country_name" class="form-control" placeholder="Input Country Name">
            <span class="text-danger error-text country_name_error"></span>
          </div>

          <div class="form-group">
            <label for="capital_city">Capital City</label>
            <input type="text" name="capital_city" class="form-control" placeholder="Input Capital City">
            <span class="text-danger error-text capital_city_error"></span>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary px-4">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>