@extends('site.innerPages.layout.master')


@section('content')
    <div class="content-header">
        <h1>Company Profile</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Calendar</a></li>
                <li class="breadcrumb-item active">Company Calendar</li>
            </ol>
        </nav>
    </div>
    <div class="content-body">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h4 class="mb-2">
                    <i class="fas fa-calendar-alt text-primary me-2"></i> Company Calendar
                </h4>
                <p class="text-muted">Manage company-wide events visible to all employees</p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    <i class="fas fa-plus me-2"></i> Add Event
                </button>
            </div>
        </div>

        <!-- Calendar View Switcher -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="calendarView" id="monthView" checked>
                    <label class="btn btn-outline-primary" for="monthView">
                        <i class="fas fa-calendar"></i> Month
                    </label>
                    <input type="radio" class="btn-check" name="calendarView" id="weekView">
                    <label class="btn btn-outline-primary" for="weekView">
                        <i class="fas fa-calendar-week"></i> Week
                    </label>
                    <input type="radio" class="btn-check" name="calendarView" id="listView">
                    <label class="btn btn-outline-primary" for="listView">
                        <i class="fas fa-list"></i> List
                    </label>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-outline-secondary me-2" onclick="navigateCalendar('prev')">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn btn-outline-secondary me-2" onclick="navigateCalendar('today')">Today</button>
                <button class="btn btn-outline-secondary" onclick="navigateCalendar('next')">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Calendar Header -->
        <div class="content-card mb-4">
            <div class="card-body text-center">
                <h3 id="currentMonth">January 2025</h3>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="content-card">
            <div class="card-body p-0">
                <div class="calendar-container">
                    <!-- Calendar Weekdays Header -->
                    <div class="calendar-weekdays">
                        <div class="weekday">Sunday</div>
                        <div class="weekday">Monday</div>
                        <div class="weekday">Tuesday</div>
                        <div class="weekday">Wednesday</div>
                        <div class="weekday">Thursday</div>
                        <div class="weekday">Friday</div>
                        <div class="weekday">Saturday</div>
                    </div>

                    <!-- Calendar Days Grid -->
                    <div class="calendar-days">
                        <!-- Previous Month Days (Inactive) -->
                        <div class="calendar-day inactive">
                            <div class="day-number">29</div>
                        </div>
                        <div class="calendar-day inactive">
                            <div class="day-number">30</div>
                        </div>
                        <div class="calendar-day inactive">
                            <div class="day-number">31</div>
                        </div>

                        <!-- Current Month Days -->
                        <div class="calendar-day">
                            <div class="day-number">1</div>
                            <div class="day-events">
                                <div class="event-item event-meeting" onclick="viewEvent(1)">
                                    <i class="fas fa-users"></i> Team Meeting
                                </div>
                            </div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">2</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">3</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">4</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">5</div>
                            <div class="day-events">
                                <div class="event-item event-training" onclick="viewEvent(2)">
                                    <i class="fas fa-graduation-cap"></i> Training Workshop
                                </div>
                            </div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">6</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">7</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">8</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">9</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">10</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">11</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">12</div>
                            <div class="day-events">
                                <div class="event-item event-deadline" onclick="viewEvent(3)">
                                    <i class="fas fa-flag"></i> Project Deadline
                                </div>
                            </div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">13</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">14</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">15</div>
                            <div class="day-events">
                                <div class="event-item event-meeting" onclick="viewEvent(4)">
                                    <i class="fas fa-video"></i> All-Hands Meeting
                                </div>
                                <div class="event-item event-social" onclick="viewEvent(5)">
                                    <i class="fas fa-birthday-cake"></i> Team Lunch
                                </div>
                            </div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">16</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">17</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">18</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">19</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">20</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">21</div>
                        </div>
                        <div class="calendar-day today">
                            <div class="day-number">22</div>
                            <div class="today-badge">Today</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">23</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">24</div>
                            <div class="day-events">
                                <div class="event-item event-training" onclick="viewEvent(6)">
                                    <i class="fas fa-laptop-code"></i> Tech Workshop
                                </div>
                            </div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">25</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">26</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">27</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">28</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">29</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">30</div>
                        </div>
                        <div class="calendar-day">
                            <div class="day-number">31</div>
                            <div class="day-events">
                                <div class="event-item event-holiday" onclick="viewEvent(7)">
                                    <i class="fas fa-star"></i> End of Month Review
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events List -->
        <div class="content-card mt-4">
            <div class="card-header">
                <h4>Upcoming Events</h4>
            </div>
            <div class="card-body">
                <div class="upcoming-events-list">
                    <div class="upcoming-event-item">
                        <div class="event-date-box">
                            <div class="event-month">JAN</div>
                            <div class="event-day">24</div>
                        </div>
                        <div class="event-details">
                            <h6>Team Building Workshop</h6>
                            <p class="mb-1"><i class="fas fa-clock text-primary"></i> 10:00 AM - 2:00 PM</p>
                            <p class="mb-0"><i class="fas fa-map-marker-alt text-danger"></i> Conference Room A</p>
                        </div>
                        <div class="event-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="editEvent(1)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteEvent(1)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="upcoming-event-item">
                        <div class="event-date-box">
                            <div class="event-month">JAN</div>
                            <div class="event-day">28</div>
                        </div>
                        <div class="event-details">
                            <h6>Monthly All-Hands Meeting</h6>
                            <p class="mb-1"><i class="fas fa-clock text-primary"></i> 3:00 PM - 4:30 PM</p>
                            <p class="mb-0"><i class="fas fa-video text-success"></i> Online via Zoom</p>
                        </div>
                        <div class="event-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="editEvent(2)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteEvent(2)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="upcoming-event-item">
                        <div class="event-date-box">
                            <div class="event-month">FEB</div>
                            <div class="event-day">02</div>
                        </div>
                        <div class="event-details">
                            <h6>New Employee Orientation</h6>
                            <p class="mb-1"><i class="fas fa-clock text-primary"></i> 9:00 AM - 12:00 PM</p>
                            <p class="mb-0"><i class="fas fa-map-marker-alt text-danger"></i> Training Room</p>
                        </div>
                        <div class="event-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="editEvent(3)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteEvent(3)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-plus me-2"></i> Add Company Event
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addEventForm">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Event Title</label>
                                <input type="text" class="form-control" placeholder="e.g. Team Meeting" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Event Type</label>
                                <select class="form-select">
                                    <option value="">Select Type</option>
                                    <option value="meeting">Meeting</option>
                                    <option value="training">Training/Workshop</option>
                                    <option value="deadline">Deadline</option>
                                    <option value="social">Social Event</option>
                                    <option value="holiday">Holiday/Off</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <select class="form-select">
                                    <option value="">Select Location</option>
                                    <option value="office">Office</option>
                                    <option value="online">Online/Zoom</option>
                                    <option value="external">External Location</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Start Time</label>
                                <input type="time" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Time</label>
                                <input type="time" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description (Optional)</label>
                                <textarea class="form-control" rows="3" placeholder="Event details..."></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="allDay">
                                    <label class="form-check-label" for="allDay">
                                        All-day event
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sendNotification" checked>
                                    <label class="form-check-label" for="sendNotification">
                                        Send notification to all employees
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveEvent()">
                        <i class="fas fa-save me-1"></i> Save Event
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Event Modal -->
    <div class="modal fade" id="viewEventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="event-detail-view">
                        <h4 id="eventTitle">Team Building Workshop</h4>
                        <div class="detail-item">
                            <i class="fas fa-calendar text-primary"></i>
                            <span id="eventDate">January 24, 2025</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-clock text-success"></i>
                            <span id="eventTime">10:00 AM - 2:00 PM</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <span id="eventLocation">Conference Room A</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-tag text-warning"></i>
                            <span id="eventType">Training/Workshop</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-align-left text-info"></i>
                            <p id="eventDescription">Team building activities and workshops to improve collaboration.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editEventFromView()">
                        <i class="fas fa-edit me-1"></i> Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
