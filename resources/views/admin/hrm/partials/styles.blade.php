<style>
.hrm-form {
    display: grid;
    gap: 0.6rem;
}
.hrm-form label {
    font-weight: 600;
    color: #374151;
}
.hrm-form input,
.hrm-form select {
    width: 100%;
    padding: 0.55rem 0.7rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    box-sizing: border-box;
}
.form-error {
    color: #dc2626;
    font-size: 0.78rem;
}
.table-actions {
    display: flex;
    gap: 0.4rem;
    align-items: center;
}
.table-actions form {
    margin: 0;
}
.alert-error {
    background: #fee2e2;
    color: #991b1b;
}
.validation-error-list {
    margin: 0.5rem 0 0;
    padding-left: 1.25rem;
}
.validation-error-list li {
    margin-top: 0.25rem;
}
@media (max-width: 900px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}
</style>
