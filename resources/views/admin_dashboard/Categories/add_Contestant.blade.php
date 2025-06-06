@extends('layouts.admin_layout')
@section('content')
    <!-- Page Title and Breadcrumb -->
    <x-admin-nav-menu-manage />


    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if (session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    <!-- Main Content Section -->
    <div class="flex">
        <!-- Form Section -->
        <div class="w-1/2 p-2 mt-8">
            <form id="contestantForm" method="POST" action="{{ route('store.contestant') }}" enctype="multipart/form-data">
                @csrf
                <!-- CSRF protection -->
                <button
                    class="text-white mb-2 bg-green-700 hover:bg-green-900 
                    focus:ring-4 focus:outline-none focus:ring-green-300 font-medium text-sm 
                    w-full sm:w-auto px-5 py-1.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                    id="addFormButton" type="button">
                    <i class="fa-solid fa-check-to-slot"></i> Add form
                </button>
                <span
                    class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300"
                    id="formCount">Total Forms: 1
                </span>
                <span
                    class="bg-green-100 text-green-800 text-sm font-medium ms-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                    {{ $event->event_name }}
                </span>

                <!-- Hidden input field to store the event ID -->
                <input name="event_id" type="hidden" value="{{ $event->id }}">

                <div id="contestantFormsContainer">
                    <!-- Initial Contestant Form -->
                    <div
                        class="contestant-form flex flex-col space-y-4 relative p-4 border border-gray-300 rounded-lg mb-4 bg-white dark:bg-gray-800 dark:border-gray-600">
                        <!-- Remove Button -->
                        <button
                            class="removeFormButton absolute top-0 right-0 m-2 text-red-700 hover:text-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-sm w-auto px-2 py-1 text-center dark:text-red-600 dark:hover:text-red-700 dark:focus:ring-red-800"
                            type="button"><i class="fa-solid fa-xmark"></i></button>

                        <div class="relative z-0 w-full mb-5 group">
                            <label class="block mb-2 text-sm font-medium text-gray-500" for="profile">Upload Contestant
                                Profile</label>

                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                id="profile" name="profile[]" type="file" aria-describedby="profile_help"
                                accept="image/*">
                            <!-- Image preview element -->
                            <img class="mt-2 hidden w-20 h-32 object-cover rounded-lg" id="imagePreview" src="#"
                                alt="Image Preview" />
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer focus:placeholder-gray-500 focus-within:text-gray-900"
                                id="number" name="number[]" type="number" placeholder=" " required />
                            <label
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                for="number">Contestant Number</label>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <input
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer focus:placeholder-gray-500 focus-within:text-gray-900"
                                id="name" name="name[]" type="text" placeholder=" " required />
                            <label
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                for="name">Contestant Name</label>
                        </div>
                        <!-- Add this new field for category -->
                        <div class="relative z-0 w-full mb-5 group">
                            <label class="block mb-2 text-sm font-medium text-gray-500" for="category">Category
                                (Optional)</label>
                            <select
                                class="block w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                id="category" name="category[]">
                                <option value="">Select category (optional)</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>


                    </div>
                </div>

                <!-- Buttons to Add More Forms and Submit -->
                <button
                    class="text-white bg-blue-500 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium  text-sm w-full sm:w-auto px-5 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="submit"><i class="fa-regular fa-circle-check"></i> Submit</button>
            </form>
        </div>

        <!-- Contestant Table Section -->
        <div class="flex-1 pt-8">
            <button
                class="text-white bg-yellow-700 hover:bg-yellow-900 focus:ring-4 
            focus:outline-none focus:ring-yellow-300 font-medium text-lg w-10 h-10 
             rounded-full flex items-center justify-center 
             float-right mb-4"
                id="toggleTextareaButton">
                <i class="fa-solid fa-marker"></i>
            </button>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h4 class="text-lg font-semibold text-gray-800">CONTESTANTS DATA </h4>
                        <input class=" border-none rounded-lg bg-opacity-10 ml-24" id="myInput" name="keyword"
                            type="text" placeholder="Search...">
                        <i class='bx bx-filter'></i>
                    </div>
                    @if ($contestants->isEmpty())
                        <p class="text-center text-red-500 mt-4">No contestants found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table table-xs" id="myTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contestants as $contestant)
                                        <tr>
                                            <td>{{ $contestant->number }}</td>
                                            <td><img class="w-8 h-8 object-cover rounded-full"
                                                    src="{{ asset($contestant->profile) }}"
                                                    alt="{{ $contestant->name }} Image">
                                            </td>
                                            <td>{{ $contestant->name }}</td>
                                            <td class="flex gap-1">
                                                <form action="{{ route('contestants.destroy', $contestant->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this contestant?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="bg-red-400 hover:bg-red-600 text-white pl-2 pr-2 rounded-sm delete-btn p-2"
                                                        type="submit">
                                                        <i class="fa-solid fa-trash-can-arrow-up"></i>
                                                    </button>

                                                </form>
                                                <button
                                                    class="bg-blue-400 hover:bg-blue-600 text-white pl-2 p-2 pr-2 rounded-sm edit-btn"
                                                    data-modal-target="static-modal" data-modal-toggle="static-modal"
                                                    data-id="{{ $contestant->id }}" type="button">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            <div class="fixed bottom-0 right-0 bg-gray-50 border border-gray-200 p-4 sm:p-6 rounded-lg shadow-lg m-4 w-full sm:w-[610px] max-w-full transition-all duration-500 ease-in-out transform translate-y-full opacity-0"
                id="textareaContainer">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Input Contestants Information(Optional)</h3>
                <textarea class="w-full h-[250px] p-3 border border-gray-300 rounded-lg bg-gray-800 text-white"
                    id="persistentTextarea" placeholder="Type your text here
                               {........Names, Number, Category, etc........}">
                </textarea>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const toggleButton = document.getElementById('toggleTextareaButton');
                    const textareaContainer = document.getElementById('textareaContainer');

                    // Check localStorage for visibility state
                    if (localStorage.getItem('textareaVisible') === 'true') {
                        textareaContainer.classList.remove('translate-y-full', 'opacity-0');
                    }

                    toggleButton.addEventListener('click', function() {
                        textareaContainer.classList.toggle('translate-y-full');
                        textareaContainer.classList.toggle('opacity-0');
                        // Save the visibility state to localStorage
                        localStorage.setItem('textareaVisible', !textareaContainer.classList.contains(
                            'translate-y-full'));
                    });
                });
            </script>
        </div>
    </div>

   <!-- Main modal -->
<div class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden"
id="static-modal" data-modal-backdrop="static" aria-hidden="true" tabindex="-1">
<div class="relative p-4 w-full max-w-2xl max-h-full">
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-2 md:p-2 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Edit Contestant
            </h3>
            <button
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="static-modal" type="button">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <!-- Success message area -->
        <div class="hidden p-4 mb-4 text-sm text-green-800 text-center" id="successMessage" role="alert"> <i
                class='bx bxs-check-circle'></i>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-4">
            <form id="editContestantForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input id="editContestantId" name="id" type="hidden">
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="editName">Name</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        id="editName" name="name" type="text" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="editNumber">Number</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        id="editNumber" name="number" type="number" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="editCategory">Category</label>
                    <select
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                        id="editCategory" name="category">
                        <option value="">Select category (optional)</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="editProfile">Profile Image</label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        id="editProfile" name="profile" type="file" accept="image/*">
                </div>
            </form>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                id="updateContestant" type="button"><i class="fa-solid fa-file-pen"></i> Update</button>
            <button
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                data-modal-hide="static-modal" type="button"><i class="fa-solid fa-xmark"></i> Cancel</button>
        </div>
    </div>
</div>
</div>

    <script>
        $(document).ready(function() {
            // Edit button click handler
            $('.edit-btn').on('click', function() {
                const contestantId = $(this).data('id');
                $.ajax({
                    url: `/contestants/${contestantId}/edit`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#editContestantId').val(data.id);
                        $('#editName').val(data.name);
                        $('#editNumber').val(data.number);
                        $('#editCategory').val(data.category || '');
                        // Open the modal
                        $('#static-modal').removeClass('hidden');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching contestant data:', error);
                    }
                });
            });

            // Update button click handler
            $('#updateContestant').on('click', function() {
                const form = $('#editContestantForm')[0];
                const formData = new FormData(form);
                const contestantId = $('#editContestantId').val();

                $.ajax({
                    url: `/contestants/${contestantId}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.success) {
                            // Show success message in the modal
                            const successMessage = $('#successMessage');
                            successMessage.text(data.message);
                            successMessage.removeClass('hidden');

                            // Scroll to the top of the modal to ensure the message is visible
                            $('.modal-content').scrollTop(0);

                            // Set a timeout to hide the success message
                            setTimeout(function() {
                                successMessage.addClass('hidden');
                            }, 3000); // Hide after 3 seconds

                            // Optionally, update the form fields with the new data
                            if (data.contestant) {
                                $('#editName').val(data.contestant.name);
                                $('#editNumber').val(data.contestant.number);
                                $('#editCategory').val(data.contestant.category || '');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating contestant:', error);
                        // Optionally, show an error message in the modal
                    }
                });
            });

            // Reset modal when it's closed
            $('[data-modal-hide="static-modal"]').on('click', function() {
                $('#successMessage').addClass('hidden');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "paging": true,
                "searching": false,
                "lengthChange": true,
                "pageLength": 5,
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
            });
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle image preview
            function previewImage(input, previewElement) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        previewElement.src = e.target.result;
                        previewElement.classList.remove('hidden'); // Show the image preview
                    };
                    reader.readAsDataURL(input.files[0]); // Convert image to base64 string
                }
            }

            // Attach event listeners to all current and future file inputs
            document.getElementById('contestantFormsContainer').addEventListener('change', function(event) {
                if (event.target && event.target.matches('input[type="file"]')) {
                    var formGroup = event.target.closest('.contestant-form');
                    var previewElement = formGroup.querySelector('img[id="imagePreview"]');
                    previewImage(event.target, previewElement);
                }
            });

            // Existing logic to handle adding new forms and remove buttons
            function updateRemoveButtons() {
                var forms = document.querySelectorAll('.contestant-form');
                var removeButtons = document.querySelectorAll('.removeFormButton');

                // Update the form count
                document.getElementById('formCount').textContent = `Total Forms: ${forms.length}`;

                // Hide all remove buttons if there is only one form
                if (forms.length === 1) {
                    removeButtons.forEach(function(button) {
                        button.style.display = 'none';
                    });
                } else {
                    removeButtons.forEach(function(button) {
                        button.style.display = 'block';
                    });
                }
            }

            document.getElementById('addFormButton').addEventListener('click', function() {
                var formContainer = document.getElementById('contestantFormsContainer');
                var initialForm = document.querySelector('.contestant-form').cloneNode(true);

                // Clear input values and hide the image preview in the cloned form
                initialForm.querySelectorAll('input').forEach(function(input) {
                    input.value = '';
                });
                var previewImageElement = initialForm.querySelector('img[id="imagePreview"]');
                previewImageElement.src = '#';
                previewImageElement.classList.add('hidden');

                formContainer.appendChild(initialForm);

                // Attach event listener to the new Remove button
                initialForm.querySelector('.removeFormButton').addEventListener('click', function() {
                    initialForm.remove();
                    updateRemoveButtons();
                });

                updateRemoveButtons();
            });

            // Attach event listener to the initial Remove button
            document.querySelector('.removeFormButton').addEventListener('click', function() {
                this.closest('.contestant-form').remove();
                updateRemoveButtons();
            });

            // Initial call to update remove button visibility and form count
            updateRemoveButtons();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('persistentTextarea');

            // Load saved text from localStorage
            textarea.value = localStorage.getItem('textareaContent') || '';

            // Save text to localStorage on input
            textarea.addEventListener('input', function() {
                localStorage.setItem('textareaContent', textarea.value);
            });
        });
    </script>
@endsection
