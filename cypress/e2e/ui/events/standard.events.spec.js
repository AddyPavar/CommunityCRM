/// <reference types="cypress" />

context("Standard User Session", () => {
    it("Visit Event Attendance", () => {
        cy.loginStandard("EventAttendance.php");
        cy.contains("Community Service");
    });

    it("Visit Community Servers", () => {
        cy.loginStandard(
            "EventAttendance.php?Action=List&Event=1&Type=Community%20Service",
        );
        cy.contains("Christmas Service");
        cy.get("#Non-Attending-1").click();
        cy.contains("Berry, Miss Brianna");
    });

    it("CheckIn People", () => {
        cy.loginStandard("Checkin.php");
        cy.contains("Event Checkin");
        cy.get("#EventID").select("Summer Camp");
        cy.contains("Add Attendees for Event: Summer Camp");
        cy.contains("Mark Smith");
    });
});
