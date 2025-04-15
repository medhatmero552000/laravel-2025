<!-- core:js -->
<script src="{{ asset('admin-assets') }}/vendors/core/core.js"></script>
<!-- endinject -->

<!-- Plugin js for this page -->
<script src="{{ asset('admin-assets') }}/vendors/flatpickr/flatpickr.min.js"></script>
<script src="{{ asset('admin-assets') }}/vendors/apexcharts/apexcharts.min.js"></script>
<!-- End plugin js for this page -->

<!-- inject:js -->
<script src="{{ asset('admin-assets') }}/vendors/feather-icons/feather.min.js"></script>
<script src="{{ asset('admin-assets') }}/js/template.js"></script>
<!-- endinject -->

<!-- Custom js for this page -->
<script src="{{ asset('admin-assets') }}/js/dashboard-dark.js"></script>
<!-- End custom js for this page -->
{{-- <script src="jquery.repeater.js"></script> --}}

<script src="{{ asset('admin-assets') }}/js/form_repeater.js"></script>
{{-- Check All --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.row-checkbox');
        const deleteButton = document.getElementById('deleteAll');
        const selectedIdsInput = document.getElementById('selectedIds'); // الحقل المخفي

        // تحديث حالة الزر بناءً على العناصر المحددة
        function updateDeleteButtonState() {
            const selectedIds = [...checkboxes].filter(cb => cb.checked).map(cb => cb
            .value); // استخدام `value` هنا
            selectedIdsInput.value = JSON.stringify(selectedIds); // وضع الـ IDs في الحقل المخفي
            deleteButton.disabled = selectedIds.length === 0; // تفعيل/تعطيل الزر حسب التحديد
        }

        // تحديد الكل
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateDeleteButtonState();
        });

        // أي تغيير في checkbox فردي
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                checkAll.checked = [...checkboxes].every(c => c.checked);
                updateDeleteButtonState();
            });
        });

        // التحقق قبل إرسال النموذج
        document.getElementById('deleteSelectedForm').addEventListener('submit', function(e) {
            e.preventDefault(); // منع الإرسال الافتراضي للنموذج

            const selectedIds = JSON.parse(selectedIdsInput.value);
            if (selectedIds.length === 0) {
                return; // لا تفعل شيء إذا لم يتم تحديد أي عنصر
            } else {
                // إرسال الطلب إلى السيرفر عبر fetch
                fetch(this.action, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            ids: selectedIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // تحديث الصفحة بعد الحذف بنجاح
                        }
                    });
            }
        });
    });
</script>
{{-- ٍSelectox Lib --}}
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
    const element = document.getElementById('grade_id');
    const choices = new Choices(element, {
        searchEnabled: true,
        itemSelectText: '',
    });
</script>
