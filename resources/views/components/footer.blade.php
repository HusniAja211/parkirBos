</div>
    </main>

    {{-- FOOTER SECTION --}}
    <footer class="bg-gray-100 border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-sm text-slate-500">
                        &copy; {{ date('Y') }} AdminPanel System. All rights reserved.
                    </p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-slate-400 hover:text-blue-500 transition text-sm">Privacy Policy</a>
                    <a href="#" class="text-slate-400 hover:text-blue-500 transition text-sm">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    showSuccessAlert("{{ session('success') }}");
});
</script>
@endif

</body>
</html>