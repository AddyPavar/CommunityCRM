/// <reference types="cypress" />

context("Standard Education Initiative", () => {
    it("View Education Initiative dashboard", () => {
        cy.loginStandard("educationinitiative/EducationInitiativeDashboard.php");
        cy.contains("Education Initiative Dashboard");
        cy.contains("Education Initiative Classes");
        cy.contains("Students not in a Education Initiative Class");
    });
});
