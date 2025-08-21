<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('employees.store')}}" method="post" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <label for="name">name :</label>
                    <input type="text" class="form-control" id="name" name="name" style=" height: 30px"
                        placeholder="name .. " required />


                    <label for="email">email :</label>
                    <input type="text" class="form-control" id="email" name="email"style=" height: 40px"
                        placeholder="email .." required />

                    <label for="phone">phone :</label>
                    <input type="number" class="form-control" id="phone" name="phone"style=" height: 30px"
                        placeholder="phone .." required />

                        <label for="salary">salary</label>
                        <input type="number" class="form-control" id="salary" name="salary" style="height:30px" placeholder="salary .." step="0.01" required />


                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" style=" height: 30px" autocomplete="new-password"
                        placeholder="password .." required />

                    <label for="password-confirm">Password</label>
                    <input type="password" class="form-control" id="password-confirm" name="password-confirm" style=" height: 30px" autocomplete="new-password"
                        placeholder="password confirm .." required />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
