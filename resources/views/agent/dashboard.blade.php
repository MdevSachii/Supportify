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

                    <div x-show="isShowNoTickets">
                        <div class="flex justify-center mt-5">
                            <div class="max-w-md px-6 py-6 text-sm text-yellow-800 rounded-lg bg-yellow-50">
                                <span class="font-medium">No Tickets!</span> These filter params are no tickets.
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex flex-wrap justify-center">
                        <template x-for="(ticket, index) in paginatedTickets" :key="index">
                            <button @Click="ticketOpen(ticket)" class="w-full sm:w-1/2 md:w-1/3 p-2">
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
            <div x-data="{ ticket_id: selectedTicketId }">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <x-ticket-view />
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
                    selectedTicketId: '',
                    isShowNoTickets: false,
                    allTicketsRoute: "{{ route('ticket.all') }}",
                    changeStatusRoute: "{{ route('ticket.open', ['id' => ':id']) }}",

                    init() {
                        this.loadTickets();
                    },

                    async ticketOpen(ticket) {
                        if (ticket.status == 'New') {
                            await this.changeTicketStatus(ticket.id);
                        }
                        this.selectedTicketId = ticket.id;
                        this.isOpenTicket = true
                    },

                    async changeTicketStatus(id) {
                        const url = (this.changeStatusRoute).replace(':id', id);
                        const response = await fetch(url, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            }
                        });

                        if (response.ok) {
                            this.loadTickets();
                            window.toastr.success('Ticket Opend!');
                        } else {
                            window.toastr.error('Ticket Open faild!');
                        }
                    },

                    async loadTickets() {
                        const response = await fetch(this.allTicketsRoute + `?customer=${this.customerName}`, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            }
                        });

                        if (!response.ok) {
                            window.toastr.error('Ticket fatcing faild!');
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
