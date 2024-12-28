<x-app-layout>
    <div class="py-12" x-data="customerTickets()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-wrap justify-center gap-2">
                        <div class="flex items-center w-full sm:max-w-sm">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <i class="fa-solid fa-ticket"></i>
                                </div>
                                <input @keyup.enter="loadTickets()" x-model="customerName" type="text"
                                    id="simple-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="Search by customer name..." required />
                            </div>
                            <button @Click="loadTickets()" type="submit"
                                class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span class="sr-only">Search</span>
                            </button>
                        </div>
                    </div>

                    <template x-if="isShowNoTickets">
                        <div class="flex justify-center mt-5">
                            <div class="max-w-md px-6 py-6 text-sm text-yellow-800 rounded-lg bg-yellow-50">
                                <span class="font-medium">No Tickets!</span> These filter params are no tickets.
                            </div>
                        </div>
                    </template>

                    <div class="mt-10 flex flex-wrap justify-center">
                        <template x-for="(ticket, index) in paginatedTickets" :key="index">
                            <button @Click="openTicketView()" class="w-full sm:w-1/2 md:w-1/3 p-2">
                                <div class="relative px-6 py-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100"
                                    :class="{
                                        'bg-yellow-100 border border-yellow-200 hover:bg-yellow-200': ticket
                                            .status === 'New'
                                    }">
                                    <span x-text="ticket.status"
                                        class="absolute -top-2 -end-2 text-xs font-medium me-2 px-2.5 py-0.5 rounded"
                                        :class="{
                                            'bg-red-100 text-red-800': ticket.status === 'New',
                                            'bg-yellow-100 text-yellow-800': ticket.status === 'Open',
                                            'bg-green-100 text-green-800': ticket.status === 'Resolved'
                                        }"></span>
                                    <div>
                                        <div class="flex justify-between">
                                            <p x-text="ticket.reference_number"
                                                class="font-normal text-xs text-gray-500"></p>
                                            <p x-text="formatDate(ticket.created_at)"
                                                class="font-normal text-xs text-gray-500"></p>
                                        </div>
                                        <h5 x-text="ticket.customer.name"
                                            class="mt-2 text-2xl font-bold tracking-tight text-gray-900"></h5>
                                        <p x-text="ticket.customer.email" class="font-normal text-xs text-gray-500"></p>
                                    </div>
                                </div>
                            </button>
                        </template>
                    </div>

                    <div class="mt-6 flex justify-center">
                        <button @click="prevPage()" :disabled="page === 1"
                            class="mx-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 disabled:opacity-50">Previous</button>
                        <button @click="nextPage()" :disabled="page >= totalPages"
                            class="mx-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 disabled:opacity-50">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <template x-if="isOpenTicket">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div>
                            <div class="mt-10 flex justify-center">
                                <div
                                    class="relative max-w-md px-6 py-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                                    <span
                                        class="absolute -top-2 -end-2 bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Pending</span>
                                    <div>
                                        <div class="flex justify-between">
                                            <p class="font-normal text-xs text-gray-500">#123456789</p>
                                            <p class="font-normal text-xs text-gray-500">22:18 27/12/2024</p>
                                        </div>

                                        <h5 class="text-left mt-2 text-2xl font-bold tracking-tight text-gray-900">
                                            Shehara Thrimavithana
                                        </h5>
                                        <p class="text-left font-normal text-xs text-gray-500">work.thrima@gmail.com</p>

                                        <p class="text-left mt-2 font-normal text-gray-700">Here are the biggest
                                            enterprise
                                            technology acquisitions of 2021 so far, in reverse chronological order.</p>
                                    </div>

                                    <div class="relative mt-5 p-4 border border-gray-300 rounded-lg bg-gray-50">
                                        <div class="absolute -top-2 -start-2">
                                            <i class="fa-brands fa-rocketchat"></i>
                                        </div>

                                        <div class="flex justify-between">
                                            <h3 class="text-lg font-medium text-gray-800">Sachini
                                                Wijesinghe</h3>
                                            <p class="font-normal text-xs text-gray-500 self-center">22:18 27/12/2024
                                            </p>
                                        </div>
                                        <div class="text-left mt-2 mb-4 text-sm text-gray-800">
                                            More info about this info dark goes here. This example text is going to run
                                            a bit
                                            longer so that you can see how spacing within an alert works with this kind
                                            of
                                            content.
                                        </div>
                                    </div>

                                    <form>
                                        <div class="my-4">
                                            <textarea id="message" rows="4"
                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Reply place here..." required></textarea>
                                            <div class="flex gap-5 mt-4">
                                                <button @click="isOpenTicket=false" type="button"
                                                    class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Close</button>

                                                <button type="submit"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Open
                                                    Ticket</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <script>
            function customerTickets() {
                return {
                    page: 1,
                    perPage: 9,
                    tickets: [],
                    isOpenTicket: false,
                    customerName: '',
                    isShowNoTickets: false,
                    allTickets: "{{ route('ticket.all') }}",

                    init() {
                        this.loadTickets();
                    },

                    openTicketView() {
                        this.isOpenTicket = true;
                    },

                    async loadTickets() {
                        const response = await fetch(this.allTickets + `?customer=${this.customerName}`, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            }
                        });

                        if (!response.ok) {
                            window.toastr.error('Refresh failed');
                            return;
                        }

                        const data = await response.json();
                        this.tickets = data.data || [];

                        if (this.tickets.length === 0) {
                            this.isShowNoTickets = true;
                        } else {
                            this.isShowNoTickets = false;
                        }
                    },

                    get paginatedTickets() {
                        const start = (this.page - 1) * this.perPage;
                        return this.tickets.slice(start, start + this.perPage);
                    },

                    get totalPages() {
                        return Math.ceil(this.tickets.length / this.perPage);
                    },

                    nextPage() {
                        if (this.page < this.totalPages) {
                            this.page++;
                        }
                    },

                    prevPage() {
                        if (this.page > 1) {
                            this.page--;
                        }
                    },

                    formatDate(isoDate) {
                        const date = new Date(isoDate);
                        return date.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                }
            }
        </script>
    </div>
</x-app-layout>
