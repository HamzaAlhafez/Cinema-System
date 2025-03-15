@if( session()->has('flash') )
<div class="flash-message fixed-bottom bg-light border rounded p-3" id="flashMessage" style="bottom:15px; right:15px; left:auto;">
    <span class="text-{{ session('flash') }} font-weight-bold">{{ session('message') }}</span>
</div>
@endif

<script>
    // تأكد من وجود الرسالة
    document.addEventListener("DOMContentLoaded", function() {
        var flashMessage = document.getElementById("flashMessage");
        if (flashMessage) {
            // إخفاء الرسالة بعد 10 ثوانٍ
            setTimeout(function() {
                flashMessage.style.display = 'none';
            }, 10000); // 10000 مللي ثانية = 10 ثوانٍ
        }
    });
</script>