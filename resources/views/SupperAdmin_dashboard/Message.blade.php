@extends('layouts.Supper_admin')

@section('content')
<div class="container mx-auto px-4 py-6 min-h-screen">
    <div class="bg-white rounded-lg shadow-md h-[calc(100vh-8rem)]">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Feedback Messages</h2>
            <button id="delete-selected" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                Delete Selected
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">
                            <input type="checkbox" id="select_all">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($feedbacks as $feedback)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <input type="checkbox" name="ids[]" value="{{ $feedback->id }}">
                            </td>
                            <td class="px-6 py-4">{{ $feedback->email }}</td>
                            <td class="px-6 py-4">{{ $feedback->phone ?? 'N/A' }}</td>
                            <td class="px-6 py-4 ">
                                <button onclick="showMessageModal('{{ addslashes($feedback->message) }}', '{{ addslashes($feedback->email) }}')" 
                                class="text-blue-500 hover:text-blue-700 bg-yellow-300 px-2 py-1 rounded-md">view</button>
                            </td>
                            <td class="px-6 py-4">{{ $feedback->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="bx bxs-trash p-1 text-red-500 rounded-full cursor-pointer" title="Delete"></i>
                                        
                                    </button>
                                </form>
                              
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<dialog id="my_modal_3" class="modal">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold text-blue-500"></h3>
        <p class="py-4"></p>
    </div>
</dialog>

<script>
    document.addEventListener('livewire:navigated', () => {
        function showMessageModal(message, email) {
            document.querySelector('#my_modal_3 .py-4').innerText = message;
            document.querySelector('#my_modal_3 .text-lg').innerText = email;
            my_modal_3.showModal();
        }
        
        // Make the function globally available
        window.showMessageModal = showMessageModal;
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#delete-selected').click(function() {
            const selectedIds = $('input[name="ids[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length === 0) {
                alert('Please select at least one feedback to delete.');
                return;
            }

            if (confirm('Are you sure you want to delete the selected feedback?')) {
                $.ajax({
                    url: '{{ route("feedback.delete-multiple") }}',
                    type: 'POST',
                    data: {
                        ids: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.success);
                        location.reload(); // Reload the page to see the changes
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'An error occurred while deleting feedback.';
                        alert(errorMessage);
                    }
                });
            }
        });

        $('#select_all').change(function() {
            $('input[name="ids[]"]').prop('checked', this.checked);
        });
    });
</script>

@endsection