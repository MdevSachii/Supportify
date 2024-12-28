<div class="flex min-h-full items-center justify-center p-4 text-center" x-data="ticketFunc()">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div>
                <div class="mt-10 flex justify-center">
                    <div
                        class="relative max-w-md px-6 py-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                        <span x-text='ticket.status'
                            class="absolute -top-2 -end-2 bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded"></span>
                        <div>
                            <div class="flex justify-between">
                                <p x-text="ticket.reference_number" class="font-normal text-xs text-gray-500"></p>
                                <p x-text="formatDate(ticket.created_at)" class="font-normal text-xs text-gray-500"></p>
                            </div>

                            <h5 x-text="ticket.customer_name"
                                class="text-left mt-2 text-2xl font-bold tracking-tight text-gray-900"></h5>
                            <p x-text="ticket.customer_email" class="text-left font-normal text-xs text-gray-500"></p>

                            <p x-text="ticket.problem_description" class="text-left mt-2 font-normal text-gray-700"></p>
                        </div>

                        <template x-for="(reply, index) in ticket.replies" :key="index">
                            <div class="relative mt-5 p-4 border border-gray-300 rounded-lg bg-gray-50">
                                <div class="absolute -top-2 -start-2">
                                    <i class="fa-brands fa-rocketchat"></i>
                                </div>

                                <div class="flex justify-between">
                                    <h3 x-text="reply.user_name" class="text-lg font-medium text-gray-800"></h3>
                                    <p x-text="formatDate(reply.reply_created_at)"
                                        class="font-normal text-xs text-gray-500 self-center"></p>
                                </div>
                                <div x-text="reply.reply_message" class="text-left mt-2 mb-4 text-sm text-gray-800">
                                </div>
                            </div>
                        </template>

                        <form @submit.prevent="replyToTicket()">
                            <div class="my-4">
                                <textarea x-model="reply" id="message" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Reply place here..." required></textarea>
                                <div class="flex gap-5 mt-4">
                                    <button @click="isOpenTicket=false;" type="button"
                                        class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Close</button>

                                    <button type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Submit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function ticketFunc() {
            return {
                ticket: [],
                reply: '',
                replyTicketRoute: "{{ route('ticket.reply') }}",

                init() {
                    this.getTicketById(this.ticket_id);
                },

                async getTicketById(id) {
                    const url = (this.getTicketRoute).replace(':id', id);
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        }
                    });

                    if (!response.ok) {
                        window.toastr.error('Ticket fatcing faild');
                        return;
                    }

                    const data = await response.json();
                    this.ticket = data;
                },

                formatDate(isoDate) {
                    const date = new Date(isoDate);
                    return date.toLocaleString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    });
                },

                async replyToTicket() {
                    const response = await fetch(this.replyTicketRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            ticket_id: this.ticket_id,
                            reply: this.reply,
                        })
                    });

                    if (response.ok) {
                        this.reply = '';
                        this.getTicketById(this.ticket_id);
                        this.loadTickets();
                        window.toastr.success('Replied!');
                    } else {
                        window.toastr.error('Reply Faild');
                    }
                },
            }
        }
    </script>
</div>
