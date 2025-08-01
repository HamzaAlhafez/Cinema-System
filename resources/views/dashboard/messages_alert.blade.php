
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    @if (session()->has('add'))
        <script>
            window.onload = function() {
                notif({
                    msg: "your item has been added successfuly",
                    type: "success"
                });
            }

        </script>
    @endif
     @if (session()->has('MoiveHaveShow'))
        <script>
            window.onload = function() {
                notif({
                    msg: "the moive cannot be deleted bacause it is linked to a show",
                    type: "error"
                });
            }

        </script>
    @endif

     @if (session()->has('SearchFaild'))
        <script>
            window.onload = function() {
                notif({
                    msg: "Search Faild Please try again",
                    type: "error"
                });
            }

        </script>
    @endif
    @if (session()->has('RegisterSuccess'))
        <script>
            window.onload = function() {
                notif({
                    msg: "Your account has been successfully created!",
                    type: "success"
                });
            }

        </script>
    @endif
     @if (session()->has('PhoneorEmailDeplicate'))
        <script>
            window.onload = function() {
                notif({
                    msg: "The email or number was previously used",
                    type: "error"
                });
            }

        </script>
    @endif

     @if (session()->has('CurrentpasswordFaild'))
        <script>
            window.onload = function() {
                notif({
                    msg: "the current password is incorrect",
                    type: "error"
                });
            }

        </script>
    @endif
    

    @if (session()->has('edit'))
        <script>
            window.onload = function() {
                notif({
                    msg: "updated Successfuly!",
                    type: "success"
                });
            }

        </script>
    @endif
     @if (session()->has('Passwordchangedsuccessfully'))
        <script>
            window.onload = function() {
                notif({
                    msg: "Password changed successfully.",
                    type: "success"
                });
            }

        </script>
    @endif
      @if (session()->has('Contectus'))
        <script>
            window.onload = function() {
                notif({
                    msg: "Thank you for your message we have received your message soon",
                    type: "success"
                });
            }

        </script>
    @endif

    @if (session()->has('delete'))
        <script>
            window.onload = function() {
                notif({
                    msg: "deleted successfuly!",
                    type: "success"
                });
            }

        </script>
    @endif
    @if (session()->has('showExpirydateYet'))
        <script>
            window.onload = function() {
                notif({
                    msg: "You cannot delete a show that is scheduled for today or a future date",
                    type: "error"
                });
            }

        </script>
    @endif
    @if (session()->has('promocodehasAssociated'))
        <script>
            window.onload = function() {
                notif({
                    msg: "Cannot delete promocode because it has associated records (purchases or usages)",
                    type: "error"
                });
            }

        </script>
    @endif
    @if (session()->has('conflictingShow'))
        <script>
            window.onload = function() {
                notif({
                    msg: "There is already a show in this hall at the same time or overlapping time",
                    type: "error"
                });
            }

        </script>
    @endif
    @if (session()->has('Categoriehasmoive'))
        <script>
            window.onload = function() {
                notif({
                    msg: "the Categorie cannot be deleted bacause it is linked to a Moive",
                    type: "error"
                });
            }

        </script>
    @endif
    @if (session()->has('CategoriehasItem'))
        <script>
            window.onload = function() {
                notif({
                    msg: "the Categorie cannot be deleted bacause it is linked to a Items",
                    type: "error"
                });
            }

        </script>
    @endif

    