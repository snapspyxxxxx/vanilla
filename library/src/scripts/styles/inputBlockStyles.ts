/*
 * @author Stéphane LaFlèche <stephane.l@vanillaforums.com>
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import { globalVariables } from "@library/styles/globalStyleVars";
import { font, paddings, styleFactory, toStringColor, unit } from "@library/styles/styleHelpers";
import { formElementsVariables } from "@library/components/forms/formElementStyles";
import { percent } from "csx";
import { layoutVariables } from "@library/styles/layoutStyles";

export function inputBlockVariables(theme?: object) {
    const spacing = {
        margin: 6,
    };
    return { spacing };
}

export function inputBlockClasses(theme?: object) {
    const vars = inputBlockVariables(theme);
    const style = styleFactory("inputBlock");
    const globalVars = globalVariables(theme);
    const formElementVars = formElementsVariables(theme);

    const root = style({
        display: "block",
        marginBottom: unit(formElementVars.spacing.margin),
        $nest: {
            ".hasError": {
                $nest: {
                    ".inputText": {
                        borderColor: toStringColor(globalVars.feedbackColors.error),
                        color: toStringColor(globalVars.feedbackColors.error),
                    },
                },
            },
            "&.isHorizontal": {
                display: "flex",
                width: percent(100),
                alignItems: "center",
                flexWrap: "wrap",
                $nest: {
                    ".inputBlock-labelAndDescription": {
                        display: "inline-flex",
                        width: "auto",
                    },
                    ".inputBlock-inputWrap": {
                        display: "inline-flex",
                        flexGrow: 1,
                    },
                },
            },
        },
    });

    const errors = style("errors", {
        display: "block",
        fontSize: unit(globalVars.fonts.size.small),
    });

    const error = style("error", {
        display: "block",
        color: toStringColor(globalVars.feedbackColors.error),
        $nest: {
            "& + .inputBlock-error": {
                marginTop: unit(vars.spacing.margin),
            },
        },
    });

    const labelNote = style("labelNote", {
        display: "block",
        fontSize: unit(globalVars.fonts.size.small),
        fontWeight: globalVars.fonts.weights.normal,
        opacity: 0.6,
    });

    const labelText = style("labelText", {
        display: "block",
        fontSize: unit(globalVars.fonts.size.medium),
        fontWeight: globalVars.fonts.weights.semiBold,
        marginBottom: unit(vars.spacing.margin),
    });

    const inputWrap = style("inputWrap", {
        $nest: {
            "& + .checkbox, & + .radioButton": {
                marginTop: unit(vars.spacing.margin),
            },
        },
    });

    const labelAndDescription = style("labelAndDescription", {
        display: "block",
        width: percent(100),
    });

    const inlineLabel = style("inlineLabel", {
        height: unit(formElementVars.sizing.height),
        ...font({
            weight: globalVars.fonts.weights.bold,
            size: globalVars.fonts.size.medium,
            lineHeight: formElementVars.sizing.height,
        }),
        ...paddings({
            left: formElementVars.spacing.horizontalPadding,
            right: formElementVars.spacing.horizontalPadding,
        }),
    });

    const miniInputs = style("miniInputs", {
        display: "flex",
        flexWrap: "wrap",
    });

    const miniInput = style("miniInputs", {
        width: unit(formElementVars.miniInput.width),
    });

    const sectionTitle = style("sectionTitle", {
        ...font({
            weight: globalVars.fonts.weights.semiBold,
            lineHeight: globalVars.lineHeights.base,
        }),
        marginBottom: unit(formElementVars.spacing.margin),
    });

    return {
        root,
        errors,
        error,
        labelNote,
        labelText,
        inlineLabel,
        inputWrap,
        labelAndDescription,
        miniInputs,
        miniInput,
        sectionTitle,
    };
}
