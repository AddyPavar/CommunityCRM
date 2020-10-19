/// <reference types="cypress" />

context('Event', () => {
    beforeEach(() => {
        cy.loginAdmin();
    });


    it('Create New Event Type', () => {
        cy.visit('EventNames.php');
        cy.contains('Edit Event Types');
        cy.contains('Add Event Type');
    });

    it('Event List', () => {
        cy.visit('ListEvents.php');
        cy.contains('Listing All Church Events');
        cy.contains('Select Event Types To Display');
        cy.contains('Display Events in Year');
        cy.contains('Add New Event');
    });

    it('Create New Event', () => {
        cy.visit('EventEditor.php');
        cy.contains('Church Event Editor');
        cy.contains('Create a new Event');
    });

});
