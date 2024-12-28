<x-customer-layout>
    <div class="py-12" x-data=customerTicket()>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white h- overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-wrap justify-center gap-2">
                        <div class="flex items-center w-full sm:max-w-sm">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <i class="fa-solid fa-ticket"></i>
                                </div>
                                <input x-model="seachTicketRef" @keyup.enter="searchTicket()" type="text"
                                    id="simple-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="Search by Ticket Reference..." required />
                            </div>
                            <button @Click="searchTicket()" type="submit"
                                class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span class="sr-only">Search</span>
                            </button>
                        </div>
                        <button @Click="isModelOpen=true"
                            class="p-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Add
                            Enquiry
                        </button>
                    </div>

                    <template x-if="isOpenNoTicketAlert">
                        <div class="flex justify-center mt-5">
                            <div class="max-w-md px-6 py-6 text-sm text-red-800 rounded-lg bg-red-50">
                                <span class="font-medium">Dark alert!</span> Change a few things up and try submitting
                                again.
                            </div>
                        </div>
                    </template>

                    <template x-if="isOpenTicket">
                        <div x-data="{ ticket_id: selectedTicketId }">
                            <x-ticket-view />
                        </div>
                    </template>

                </div>
            </div>
        </div>

        <template x-if="isModelOpen">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class="relative bg-white rounded-lg shadow-xl transition-all sm:my-8 w-full max-w-lg p-6">
                            <div class="flex justify-end">
                                <button @Click="isModelOpen=false" class="text-gray-400 hover:text-gray-600">
                                    <span class="sr-only">Close</span>
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <form @submit.prevent="submitNewTicket" class="mb-4">
                                <div class="mb-4">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 text-left">Name</label>
                                    <input x-model="name" type="text" id="name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Enter your name..." />
                                </div>

                                <div class="mb-4">
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-gray-900 text-left">Email</label>
                                    <input x-model="email" type="text" id="email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Enter your email..." />
                                </div>

                                <div class="mb-4">
                                    <label for="contact_number"
                                        class="block mb-2 text-sm font-medium text-gray-900 text-left">Contact
                                        Number</label>
                                    <input x-model="contactNumber" type="number" id="contact_number"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Enter your contact number..." />
                                </div>

                                <div class="mb-4">
                                    <label for="description"
                                        class="block mb-2 text-sm font-medium text-gray-900 text-left">Ticket
                                        Description</label>
                                    <textarea x-model="description" id="description" rows="4"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Describe your issue..."></textarea>
                                </div>

                                <button type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Open
                                    Ticket</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="isOpenClipBoard">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class="relative">
                            <div class="w-full max-w-md bg-white shadow rounded-lg px-5 pb-5 pt-2 text-left">
                                <div class="flex justify-end">
                                    <button @Click="isOpenClipBoard=false; clipBoard={}"
                                        class="text-gray-400 hover:text-gray-600">
                                        <span class="sr-only">Close</span>
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-900 mb-2">Ticket details
                                </h2>
                                <div
                                    class="relative bg-gray-50 p-4 rounded-lg border border-gray-200 not-italic grid grid-cols-2">
                                    <div class="space-y-2 text-gray-500 leading-loose hidden sm:block">
                                        <span>Name</span> <br />
                                        <span>Email</span> <br />
                                        <span>Phone No.</span> <br />
                                        <span>References No.</span>
                                    </div>
                                    <div id="contact-details" class="space-y-2 text-gray-900 font-medium leading-loose">
                                        <span x-text="clipBoard.customer.name"></span> <br />
                                        <span x-text="clipBoard.customer.email">name@flowbite.com</span> <br />
                                        <span x-text="clipBoard.customer.phone_number"></span> <br />
                                        <span x-text="clipBoard.reference_number" id="ticketRef"
                                            class="text-blue-500 font-black"></span>
                                    </div>
                                    <button @click="copyTicketRef()"
                                        class="absolute end-2 top-2 text-gray-500 rounded-lg p-2 inline-flex items-center justify-center">
                                        <span id="copy">
                                            <i class="fa-solid fa-copy"></i>
                                        </span>
                                        <span id="copied" class="hidden inline-flex items-center">
                                            <i class="fa-solid fa-check-double"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <script>
            function customerTicket() {
                return {
                    isModelOpen: false,
                    isOpenClipBoard: false,
                    isOpenNoTicketAlert: false,
                    isOpenTicket: false,
                    name: 'Shehara',
                    email: 'shehara@gmail.com',
                    contactNumber: '0767199756',
                    description: 'aaaaaaaaaaaaaa',
                    ticketRef: '',
                    seachTicketRef: '',
                    clipBoard: {},
                    createTicketRoute: "{{ route('ticket.create') }}",
                    findTickerRoute: "{{ route('ticket.find', ['ref_no' => ':id']) }}",
                    ticketId: '',

                    submitNewTicket() {
                        if (this.validateForm()) {
                            this.createTicket();
                        }
                    },

                    async createTicket() {
                        const response = await fetch(this.createTicketRoute, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                name: this.name,
                                email: this.email,
                                contactNumber: this.contactNumber,
                                description: this.description
                            })
                        });

                        if (response.ok) {
                            window.toastr.success('Ticket successfully created!');
                            const data = await response.json();
                            this.clipBoard = data.ticket;
                            this.isOpenClipBoard = true;
                            this.isModelOpen = false;
                            this.description = '';
                        } else {
                            const errorData = await response.json();
                            window.toastr.error(errorData.error || 'Ticket Creation Faild');
                        }
                    },

                    async searchTicket() {
                        const url = (this.findTickerRoute).replace(':id', this.seachTicketRef);
                        const response = await fetch(url, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            }
                        });

                        if (response.ok) {
                            this.isOpenNoTicketAlert = false;
                            const data = await response.json();
                            this.selectedTicketId = data.ticket_id;
                            this.isOpenTicket = true;
                        } else {
                            this.isOpenTicket = false;
                            this.isOpenNoTicketAlert = true;
                        }
                    },

                    validateForm() {
                        let valid = true;

                        if (!this.name.trim()) {
                            window.toastr.error('Name is required');
                            valid = false;
                        }

                        if (!this.email.trim()) {
                            window.toastr.error('Email is required');
                            valid = false;
                        } else if (!this.validateEmail(this.email)) {
                            window.toastr.error('Please enter a valid email address.');
                            valid = false;
                        }

                        if (this.contactNumber.trim() && !this.validateContactNumber(this.contactNumber)) {
                            window.toastr.error('Please enter a valid Contact Number');
                            valid = false;
                        }

                        if (!this.description.trim()) {
                            window.toastr.error('Description is required');
                            valid = false;
                        }

                        return valid;
                    },

                    validateEmail(email) {
                        const regex =
                            /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                        return regex.test(String(email).toLowerCase());
                    },

                    validateContactNumber(number) {
                        const regex = /^(\+\d{1,4}[-.\s]?)?(\(\d{1,3}\)[-.\s]?)?(\d{1,4}[-.\s]?)(\d{1,4}[-.\s]?)(\d{1,9})$/;
                        if (!regex.test(number)) {
                            return false;
                        }
                        const digitsOnly = number.replace(/\D/g, '');
                        return digitsOnly.length >= 7 && digitsOnly.length <= 15;
                    },

                    copyTicketRef() {
                        const ticketRefElement = document.getElementById('ticketRef');
                        const text = ticketRefElement.innerText;
                        navigator.clipboard.writeText(text).then(() => {
                            document.getElementById('copied').style.display = 'inline-flex';
                            document.getElementById('copy').style.display = 'none';
                            window.toastr.success('References No. Copied!');
                            setTimeout(() => {
                                document.getElementById('copied').style.display = 'none';
                                document.getElementById('copy').style.display = 'inline-flex';
                            }, 2000);
                        }).catch(err => {
                            console.error('Failed to copy text: ', err);
                        });
                    }
                }
            }
        </script>
    </div>
</x-customer-layout>
