@if(session()->has('flash'))
<div class="flash-message {{ session('flash') }}" id="flashMessage">
    <span>{{ session('message') }}</span>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const flashMessage = document.getElementById('flashMessage');
        
        if (flashMessage) {
            
            setTimeout(() => {
                flashMessage.style.opacity = '0';
                flashMessage.style.transition = 'opacity 0.5s ease';
                
                
                setTimeout(() => {
                    flashMessage.remove();
                }, 500);
            }, 10000);
            
          
            flashMessage.addEventListener('click', function() {
                this.style.opacity = '0';
                setTimeout(() => this.remove(), 500);
            });
        }
    });
</script>
@endif