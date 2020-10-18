/// <reference types="cypress" />

context('Admin Debug', () => {
    beforeEach(() => {
        cy.loginAdmin();
    })

    it('View system debug', () => {
        cy.visit("v2/admin/debug");
        cy.contains('ChurchCRM Installation Information');
        cy.contains('Database');
    });

    it('View email debug', () => {
        cy.visit("v2/email/debug");
        cy.contains('Debug Email Connection');
    });

    it('View system settings', () => {
        cy.visit("SystemSettings.php");
        cy.location('pathname').should('include', "/SystemSettings.php");
    });

});

