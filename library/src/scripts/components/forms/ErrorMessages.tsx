/*
 * @author Stéphane LaFlèche <stephane.l@vanillaforums.com>
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import React from "react";
import classNames from "classnames";

import { IFieldError } from "@library/@types/api";
import { getRequiredID, IRequiredComponentID } from "@library/componentIDs";
import { inputBlockClasses } from "@library/styles/inputBlockStyles";

interface IProps extends IRequiredComponentID {
    className?: string;
    errorClassName?: string;
    errors?: IFieldError[];
}

interface IState {
    id: string;
}

export default class ErrorMessages extends React.Component<IProps, IState> {
    constructor(props) {
        super(props);
        this.state = {
            id: getRequiredID(props, "errorMessages") as string,
        };
    }

    public render() {
        const { errors } = this.props;
        const classes = inputBlockClasses();

        if (errors && errors.length > 0) {
            const errorList = (errors as any).map((error: any, index) => {
                return (
                    <span
                        key={index}
                        className={classNames(classes.error, "inputBlock-error", this.props.errorClassName)}
                    >
                        {error.message}
                    </span>
                );
            });

            return (
                <span
                    id={this.state.id}
                    className={classNames(classes.errors, "inputBlock-errors", this.props.className)}
                >
                    {errorList}
                </span>
            );
        } else {
            return null;
        }
    }
}
